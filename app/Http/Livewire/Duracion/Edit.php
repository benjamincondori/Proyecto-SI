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

    public function editarRegistro($registroSeleccionado)
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
    
        // Realizar la actualización del registro seleccionado
        $registro = Duracion::find($this->registroSeleccionado['id']);
        $registro->nombre = $this->registroSeleccionado['nombre'];
        $registro->dias_duracion = $this->registroSeleccionado['dias_duracion'];
        $registro->save();
    
        $this->emitTo('duracion.show','cerrarVista');
        $this->emit('alert', 'actualizado');
        $this->registroSeleccionado = null;
    }

    public function render()
    {
        return view('livewire.duracion.edit');
    }
}
