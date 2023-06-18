<?php

namespace App\Http\Livewire\Rol;

use App\Models\Rol;
use Livewire\Component;

class Edit extends Component
{
    public  $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:30'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro(Rol $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('rol.show','cerrarVista');
    }

    public function actualizarRol() 
    {
        $this->validate();
    
        // Realizar la actualización del registro seleccionado
        $rol = Rol::find($this->registroSeleccionado['id']);

        $rol->nombre = $this->registroSeleccionado['nombre'];

        try {
            $rol->save();
            $this->emitTo('rol.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $this->emit('error');
        }
    }

    public function render()
    {
        return view('livewire.rol.edit');
    }
}
