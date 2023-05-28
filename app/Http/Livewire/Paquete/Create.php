<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;

class Create extends Component
{
    public $id_paquete, $nombre, $descripcion;

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:100'
    ];

    // Cierra la vista de creación
    public function cancelar()
    {
        $this->emitTo('paquete.show','cerrarVista');
    }

    public function guardarPaquete() 
    {
        $this->validate();

        Paquete::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);

        $this->emitTo('paquete.show', 'cerrarVista');
        $this->emit('alert', 'guardado');
    }

    public function render()
    {
        return view('livewire.paquete.create');
    }
}
