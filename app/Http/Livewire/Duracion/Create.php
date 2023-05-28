<?php

namespace App\Http\Livewire\Duracion;

use App\Models\Duracion;
use Livewire\Component;

class Create extends Component
{
    public $id_duracion, $nombre, $dias_duracion;

    protected $rules = [
        'nombre' => 'required|max:50',
        'dias_duracion' => 'required',
    ];

    // Cierra la vista de creación
    public function cancelar()
    {
        $this->emitTo('duracion.show','cerrarVista');
    }

    public function guardarDuracion() 
    {
        $this->validate();

        Duracion::create([
            'nombre' => $this->nombre,
            'dias_duracion' => $this->dias_duracion,
        ]);

        $this->emitTo('duracion.show', 'cerrarVista');
        $this->emit('alert', 'guardado');
    }

    public function render()
    {
        return view('livewire.duracion.create');
    }
}
