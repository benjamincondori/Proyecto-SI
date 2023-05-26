<?php

namespace App\Http\Livewire\Seccion;

use App\Models\Seccion;
use Livewire\Component;

class Create extends Component
{
    public $id_seccion, $nombre, $descripcion, $capacidad;

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:150',
        'capacidad' => 'required'
    ];

    public function cancelar()
    {
        $this->emit('cancelarCreacion');
    }

    public function guardarSeccion() 
    {
        $this->validate();

        Seccion::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'capacidad' => $this->capacidad
        ]);

        $this->emitTo('seccion.show', 'render');
        $this->emit('registroGuardado');

    }

    public function render()
    {
        return view('livewire.seccion.create');
    }
}
