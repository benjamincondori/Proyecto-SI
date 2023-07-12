<?php

namespace App\Http\Livewire\Asistencia;

use App\Models\Asistencia;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado, $id_cliente;
    public $search;
    public $searchResults = [];

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'id_cliente' => 'required|exists:CLIENTE,id',
    ];

    protected $validationAttributes = [
        'id_cliente' => 'cliente',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    private function obtenerIdCliente($cadena) {
        $partes = explode('-', $cadena);
        $id = trim($partes[0]);
        return $id;
    }

    private function obtenerIdAdmin() {
        $user = Auth::user();
        return $user->empleado->id;
    }

    private function obtenerNombreCliente($id) {
        $cliente = Cliente::findOrFail($id);
        $nombre = $id.' - '.$cliente->nombres.' '.$cliente->apellidos;
        return $nombre;
    }

    public function obtenerCliente($idCliente) {
        $cliente = Cliente::findOrFail($idCliente);
        return $cliente;
    }

    // Verifica si tiene una inscripción activa (devuelve true)
    public function verificarInscripcion($idCliente) {
        $cliente = $this->obtenerCliente($idCliente);
        $inscripciones = $cliente->inscripciones;
        foreach ($inscripciones as $inscripcion) {
            $estado = $inscripcion->detalle->estado;
            if ($estado) {
                return true;
            }
        }
        return false;
    }

    // Verifica si el cliente no tiene registrado su asistencia el dia actual
    public function verificarAsistencia($idCliente) {
        $cliente = $this->obtenerCliente($idCliente);
        $asistencias = $cliente->asistencias;
        $fechaActual = date('Y-m-d');
        foreach ($asistencias as $asistencia) {
            $fecha = $asistencia->fecha_de_ingreso;
            if ($fechaActual === $fecha) {
                return true;
            }
        }
        return false;
    }

    public function updatedSearch()
    {
        if (!empty($this->search)) {
            $this->searchResults = Cliente::where(function ($query) {
                $query->where('nombres', 'like', '%'.$this->search.'%')
                    ->orWhere('apellidos', 'like', '%'.$this->search.'%')
                    ->orWhere('id', 'like', '%'.$this->search.'%');
            })->get();

            $this->id_cliente = $this->obtenerIdCliente($this->search);
            $this->validate([
                'id_cliente' => 'required|exists:CLIENTE,id',
            ]);
        } else {
            $this->searchResults = [];
            $this->id_cliente = null;
        }
    }

    public function editarRegistro(Asistencia $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->id_cliente = $this->registroSeleccionado->id_cliente;
        $this->search = $this->obtenerNombreCliente($this->id_cliente);
    }

    public function mount() {
        $this->registroSeleccionado['id_administrativo'] = $this->obtenerIdAdmin();
    }

    public function cancelar()
    {
        $this->emitTo('asistencia.show','cerrarVista');
    }

    public function actualizarRegistro() 
    {
        $this->validate();
        
        try {
            $registro = Asistencia::findOrFail($this->registroSeleccionado['id']);

            $registro->id_cliente = $this->id_cliente;
            $registro->id_administrativo = $this->registroSeleccionado['id_administrativo'];

            if (($this->verificarInscripcion($this->id_cliente) && 
                !$this->verificarAsistencia($this->id_cliente)) || 
                $this->id_cliente === $this->registroSeleccionado['id_cliente']) {

                $registro->save();

                $descripcion = 'Se actualizó el registro de asistencia con ID: '.$registro->id;
                registrarBitacora($descripcion);

                $this->emitTo('asistencia.show', 'cerrarVista');
                $this->emit('alert', 'guardado');
            } else {
                if (!$this->verificarInscripcion($this->id_cliente)) {
                    $this->emit('noInscrito');
                } else {
                    $this->emit('asistenciaDoble');
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.asistencia.edit');
    }
}
