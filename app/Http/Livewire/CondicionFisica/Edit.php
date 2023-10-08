<?php

namespace App\Http\Livewire\CondicionFisica;

use App\Models\Cliente;
use App\Models\Condicion_Fisica;
use DateTime;
use Livewire\Component;

class Edit extends Component
{
    public  $registroSeleccionado, $id_cliente;
    public $search;
    public $searchResults = [];

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.altura' => 'required',
        'registroSeleccionado.peso' => 'required',
        'registroSeleccionado.nivel' => 'required|max:30',
        'id_cliente' => 'required',
    ];

    protected $validationAttributes = [
        'registroSeleccionado.altura' => 'altura',
        'registroSeleccionado.peso' => 'peso',
        'registroSeleccionado.nivel' => 'nivel',
        'id_cliente' => 'cliente'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->id_cliente = $this->registroSeleccionado['id_cliente'];
        $this->search = $this->obtenerNombreCliente($this->id_cliente);
    }

    public function cancelar()
    {
        $this->emitTo('condicion-fisica.show','cerrarVista');
    }

    private function obtenerIdCliente($cadena) {
        $partes = explode('-', $cadena);
        $id = trim($partes[0]);
        return $id;
    }

    private function obtenerNombreCliente($id) {
        $cliente = Cliente::findOrFail($id);
        $nombre = $id.' - '.$cliente->nombres.' '.$cliente->apellidos;
        return $nombre;
    }

    private function obtenerFechaActual() {
        date_default_timezone_set('America/La_Paz');
        $fechaHoraActual = new DateTime();
        $fechaHoraActualString = $fechaHoraActual->format('Y-m-d H:i:s');
        return $fechaHoraActualString;
    }

    public function updatedSearch()
    {
        if (!empty($this->search)) {
            $this->searchResults = Cliente::where(function ($query) {
                $query->where('nombres', 'like', '%'.$this->search.'%')
                    ->orWhere('apellidos', 'like', '%'.$this->search.'%');
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

    public function actualizarRegistro() 
    {
        $this->validate();
    
        try {
            $registro = Condicion_Fisica::findOrFail($this->registroSeleccionado['id']);

            $registro->altura = $this->registroSeleccionado['altura'];
            $registro->peso = $this->registroSeleccionado['peso'];
            $registro->nivel = $this->registroSeleccionado['nivel'];
            $registro->id_cliente = $this->id_cliente;
            $registro->fecha = $this->obtenerFechaActual();

            $registro->save();

            $descripcion = 'Se actualizó el registro de condición física con ID: '.$registro->id.' del cliente con ID: '.$this->id_cliente;
            registrarBitacora($descripcion);

            $this->emitTo('condicion-fisica.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.condicion-fisica.edit');
    }
}
