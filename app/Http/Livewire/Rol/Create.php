<?php

namespace App\Http\Livewire\Rol;

use App\Models\Rol;
use Livewire\Component;

class Create extends Component
{
    public $id_rol, $nombre;

    protected $rules = [
        'nombre' => 'required|max:30'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('rol.show', 'cerrarVista');
    }

    public function guardarRol() 
    {
        $this->validate();

        $rol = new Rol;
        $rol->nombre = $this->nombre;

        try {
            $rol->save();
            $this->emitTo('rol.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $this->emit('error');
        }
    }

    public function render()
    {
        return view('livewire.rol.create');
    }
}
