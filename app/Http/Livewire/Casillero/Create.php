<?php

namespace App\Http\Livewire\Casillero;

use App\Models\Casillero;
use Livewire\Component;

class Create extends Component
{
    public $nro, $tamaño, $precio; 
    public $estado = true;

    protected $rules = [
        'nro' => 'required|unique:casillero,nro',
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

        $casillero = new Casillero;

        $casillero->nro = $this->nro;
        $casillero->tamaño = $this->tamaño;
        $casillero->precio = $this->precio;
        $casillero->estado = $this->estado;

        try {
            $casillero->save();
            $this->emitTo('casillero.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $this->emit('error');
        }

    }

    public function render()
    {
        return view('livewire.casillero.create');
    }
}
