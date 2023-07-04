<?php

namespace App\Http\Livewire\Casillero;

use App\Models\Casillero;
use Livewire\Component;

class Create extends Component
{
    public $nro, $tamaño, $precio; 
    public $estado = true;

    protected $rules = [
        'nro' => 'required|unique:CASILLERO,nro',
        'tamaño' => 'required|max:10',
        'precio' => 'required',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('casillero.show', 'cerrarVista');
    }

    public function guardarCasillero() 
    {
        $this->validate();

        try {
            $casillero = new Casillero;

            $casillero->nro = $this->nro;
            $casillero->tamaño = $this->tamaño;
            $casillero->precio = $this->precio;
            $casillero->estado = $this->estado;

            $casillero->save();

            $descripcion = 'Se creó un nuevo casillero con Nro: '.$casillero->nro;
            registrarBitacora($descripcion);

            $this->emitTo('casillero.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function render()
    {
        return view('livewire.casillero.create');
    }
}
