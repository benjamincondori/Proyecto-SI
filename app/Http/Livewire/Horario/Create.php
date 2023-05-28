<?php

namespace App\Http\Livewire\Horario;

use App\Models\Horario;
use Livewire\Component;

class Create extends Component
{
    public $id_horario, $descripcion, $hora_inicio, $hora_fin;

    protected $rules = [
        'descripcion' => 'required|max:50',
        'hora_inicio' => 'required',
        'hora_fin' => 'required'
    ];

    public function cancelar()
    {
        $this->emitTo('horario.show', 'cerrarVista');
    }

    public function guardarHorario() 
    {
        $this->validate();

        Horario::create([
            'descripcion' => $this->descripcion,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin
        ]);

        $this->emitTo('horario.show', 'cerrarVista');
        $this->emit('alert', 'guardado');

    }

    public function render()
    {
        return view('livewire.horario.create');
    }
}
