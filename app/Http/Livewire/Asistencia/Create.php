<?php

namespace App\Http\Livewire\Asistencia;

use App\Models\Asistencia;
use App\Models\Cliente;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $fecha_ingreso, $hora_ingreso, $id_cliente, $id_administrativo;
    public $search;
    public $searchResults = [];

    protected $rules = [
        'id_cliente' => 'required|exists:CLIENTE,id',
    ];

    protected $validationAttributes = [
        'id_cliente' => 'cliente',
    ];

    public function updated($propertyName) {
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

    private function obtenerFechaActual() {
        date_default_timezone_set('America/La_Paz');
        $fechaHoraActual = new DateTime();
        $fechaActualString = $fechaHoraActual->format('Y-m-d');
        return $fechaActualString;
    }

    private function obtenerHoraActual() {
        date_default_timezone_set('America/La_Paz');
        $fechaHoraActual = new DateTime();
        $HoraActualString = $fechaHoraActual->format('H:i:s');
        return $HoraActualString;
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

    public function mount() {
        $this->id_administrativo = $this->obtenerIdAdmin();
    }

    public function cancelar()
    {
        $this->emitTo('asistencia.show', 'cerrarVista');
    }

    public function guardarRegistro() {

        $this->validate();

        try {
            $registro = new Asistencia();

            $registro->id_cliente = $this->id_cliente;
            $registro->id_administrativo = $this->id_administrativo;
            $registro->fecha_de_ingreso = $this->obtenerFechaActual();
            $registro->hora_de_ingreso = $this->obtenerHoraActual();

            // dd($this->verificarAsistencia($this->id_cliente));

            if ($this->verificarInscripcion($this->id_cliente) && 
                !$this->verificarAsistencia($this->id_cliente)) {
                $registro->save();

                $descripcion = 'Se creó un nuevo registro de asistencia con ID: '.$registro->id;
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
        return view('livewire.asistencia.create');
    }
}
