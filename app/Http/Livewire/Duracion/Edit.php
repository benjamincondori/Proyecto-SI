<?php

namespace App\Http\Livewire\Duracion;

use App\Models\Duracion;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:50',
        'registroSeleccionado.dias_duracion' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro(Duracion $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('duracion.show','cerrarVista');
    }

    public function actualizarDuracion() 
    {
        $this->validate();
    
        try {
            // Realizar la actualización del registro seleccionado
            $registro = Duracion::find($this->registroSeleccionado['id']);

            $registro->nombre = $this->registroSeleccionado['nombre'];
            $registro->dias_duracion = $this->registroSeleccionado['dias_duracion'];
        
            $registro->save();

            $descripcion = 'Se actualizó la duración con ID: '.$registro->id;
            registrarBitacora($descripcion);

            $this->emitTo('duracion.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.duracion.edit');
    }
}
