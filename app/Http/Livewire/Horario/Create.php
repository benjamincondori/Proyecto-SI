<?php

namespace App\Http\Livewire\Horario;

use Livewire\Component;
use App\Models\Horario;

class Create extends Component
{
    public $id_horario, $descripcion, $hora_inicio, $hora_fin;

    protected $rules = [
        'descripcion' => 'required|max:150',
        'hora_inicio' => 'required',
        'hora_fin' => 'required'
    ];

    public function cancelar()
    {
        $this->emit('cancelarCreacion');
    }

    public function guardarHorario() 
    {
        $this->validate();

        Horario::create([
            'descripcion' => $this->descripcion,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin
        ]);

        $this->emitTo('horario.show', 'render');
        $this->emit('registroGuardado');

    }

    public function render()
    {
        return view('livewire.horario.create');
    }
}
