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

    public function cancelar()
    {
        $this->emitTo('casillero.show', 'cerrarVista');
    }

    public function guardarCasillero() 
    {
        $this->validate();

        Casillero::create([
            'nro' => $this->nro,
            'tamaño' => $this->tamaño,
            'precio' => $this->precio,
            'estado' => $this->estado
        ]);

        $this->emitTo('casillero.show', 'cerrarVista');
        $this->emit('alert', 'guardado');

    }

    public function render()
    {
        return view('livewire.casillero.create');
    }
}
