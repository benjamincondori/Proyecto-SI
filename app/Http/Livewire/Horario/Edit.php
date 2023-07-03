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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro(Horario $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('horario.show','cerrarVista');
    }

    public function actualizarHorario() 
    {
        $this->validate();
    
        try {
            // Realizar la actualización del registro seleccionado
            $registro = Horario::find($this->registroSeleccionado['id']);
            $registro->descripcion = $this->registroSeleccionado['descripcion'];
            $registro->hora_inicio = $this->registroSeleccionado['hora_inicio'];
            $registro->hora_fin = $this->registroSeleccionado['hora_fin'];
            
            $registro->save();
            $this->emitTo('horario.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function render()
    {
        return view('livewire.horario.edit');
    }
}
