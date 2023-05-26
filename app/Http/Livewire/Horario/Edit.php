<?php

namespace App\Http\Livewire\Horario;

use App\Models\Horario;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.descripcion' => 'required|max:50',
        'registroSeleccionado.hora_inicio' => 'required',
        'registroSeleccionado.hora_fin' => 'required'
    ];

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emit('cancelarEdicion');
    }

    public function actualizarHorario() 
    {
        $this->validate();
    
        // Realizar la actualización del registro seleccionado
        $registro = Horario::find($this->registroSeleccionado['id']);
        $registro->descripcion = $this->registroSeleccionado['descripcion'];
        $registro->hora_inicio = $this->registroSeleccionado['hora_inicio'];
        $registro->hora_fin = $this->registroSeleccionado['hora_fin'];
        $registro->save();
    
        $this->emitTo('horario.show','render');
        $this->emit('registroActualizado');

        // Limpiar la propiedad $registroSeleccionado
        $this->registroSeleccionado = null;

    }

    public function render()
    {
        return view('livewire.horario.edit');
    }
}
