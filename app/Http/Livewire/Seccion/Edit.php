<?php

namespace App\Http\Livewire\Seccion;

use App\Models\Seccion;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:50',
        'registroSeleccionado.descripcion' => 'required|max:150',
        'registroSeleccionado.capacidad' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro(Seccion $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('seccion.show','cerrarVista');
    }

    public function actualizarSeccion() 
    {
        $this->validate();
    
        try {
            // Realizar la actualización del registro seleccionado
            $registro = Seccion::find($this->registroSeleccionado['id']);

            $registro->nombre = $this->registroSeleccionado['nombre'];
            $registro->descripcion = $this->registroSeleccionado['descripcion'];
            $registro->capacidad = $this->registroSeleccionado['capacidad'];

            $registro->save();

            $descripcion = 'Se actualizó la sección con ID: '.$registro->id;
            registrarBitacora($descripcion);

            $this->emitTo('seccion.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function render()
    {
        return view('livewire.seccion.edit');
    }
}
