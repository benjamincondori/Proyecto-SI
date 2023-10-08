<?php

namespace App\Http\Livewire\CondicionFisica;

use App\Models\Cliente;
use App\Models\Condicion_Fisica;
use DateTime;
use Livewire\Component;

class Create extends Component
{
    public $altura, $peso, $nivel, $fecha, $id_cliente;
    public $search;
    public $searchResults = [];

    protected $rules = [
        'altura' => 'required',
        'peso' => 'required',
        'nivel' => 'required|max:30',
        'id_cliente' => 'required',
    ];

    protected $validationAttributes = [
        'id_cliente' => 'cliente'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('condicion-fisica.show', 'cerrarVista');
    }

    private function obtenerIdCliente($cadena) {
        $partes = explode('-', $cadena);
        $id = trim($partes[0]);
        return $id;
    }

    private function obtenerFechaActual() {
        date_default_timezone_set('America/La_Paz');
        $fechaHoraActual = new DateTime();
        $fechaHoraActualString = $fechaHoraActual->format('Y-m-d H:i:s');
        return $fechaHoraActualString;
    }

    public function updatedAltura() {
        if ($this->altura < 0) {
            $this->altura = 0;
        }
    }

    public function updatedPeso() {
        if ($this->peso < 0) {
            $this->peso = 0;
        }
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

    public function guardarRegistro() 
    {
        $this->validate();

        try {
            $registro = new Condicion_Fisica;

            $registro->altura = $this->altura;
            $registro->peso = $this->peso;
            $registro->nivel = $this->nivel;
            $registro->id_cliente = $this->id_cliente;
            $registro->fecha = $this->obtenerFechaActual();

            $registro->save();

            $descripcion = 'Se creó un nuevo registro de condición física con ID: '.$registro->id.' para el cliente con ID: '.$this->id_cliente;
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
        return view('livewire.condicion-fisica.create');
    }
}
