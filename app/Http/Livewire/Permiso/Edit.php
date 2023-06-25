<?php

namespace App\Http\Livewire\Permiso;

use App\Models\Permiso;
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
                'max:60',
                Rule::unique('permiso', 'nombre')->ignore($registroId),
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
        $this->emitTo('permiso.show','cerrarVista');
    }

    public function actualizarPermiso() 
    {
        $this->validate($this->getUpdateRules());
    
        try {
            // Realizar la actualización del registro seleccionado
            $permiso = Permiso::find($this->registroSeleccionado['id']);

            $permiso->nombre = $this->registroSeleccionado['nombre'];
        
            $permiso->save();

            $this->emitTo('permiso.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.permiso.edit');
    }
}
