<?php

namespace App\Http\Livewire\Rol;

use App\Models\Rol;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public  $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected function getUpdateRules() {
        $registroId = $this->registroSeleccionado['id'];

        return [
            'registroSeleccionado.nombre' => [
                'required',
                'max:30',
                Rule::unique('ROL', 'nombre')->ignore($registroId),
            ],
        ];
    }

    protected $validationAttributes = [
        'registroSeleccionado.nombre' => 'nombre'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getUpdateRules());
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('rol.show','cerrarVista');
    }

    public function actualizarRol() 
    {
        $this->validate($this->getUpdateRules());
    
        try {
            // Realizar la actualización del registro seleccionado
            $rol = Rol::find($this->registroSeleccionado['id']);

            $rol->nombre = $this->registroSeleccionado['nombre'];
            
            $rol->save();

            $descripcion = 'Se actualizó el rol con ID: '.$rol->id.' - '.$rol->nombre;
            registrarBitacora($descripcion);

            $this->emitTo('rol.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.rol.edit');
    }
}
