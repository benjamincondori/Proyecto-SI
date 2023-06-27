<?php

namespace App\Http\Livewire\Permiso;

use App\Models\Permiso;
use Livewire\Component;

class Create extends Component
{
    public $id_permiso, $nombre;

    protected $rules = [
        'nombre' => 'required|max:60|unique:PERMISO'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('permiso.show', 'cerrarVista');
    }

    public function guardarPermiso() 
    {
        $this->validate();

        try {
            $rol = new Permiso();
            $rol->nombre = $this->nombre;
        
            $rol->save();

            $this->emitTo('permiso.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.permiso.create');
    }
}
