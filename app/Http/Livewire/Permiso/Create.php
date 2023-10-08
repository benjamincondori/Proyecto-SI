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
            $permiso = new Permiso();
            $permiso->nombre = $this->nombre;
        
            $permiso->save();

            $descripcion = 'Se creó un nuevo permiso con ID: '.$permiso->id.' - '.$permiso->nombre;
            registrarBitacora($descripcion);

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
