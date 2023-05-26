<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Models\Horario;
use Livewire\Component;

class Create extends Component
{
    public $id_grupo, $nombre, $nro_integrantes, $id_disciplina, $id_entrenador, $id_horario;
    public $disciplinas, $entrenadores, $horarios;

    protected $rules = [
        'nombre' => 'required|max:40',
        'nro_integrantes' => 'required',
        'id_disciplina' => 'required',
        'id_entrenador' => 'required',
        'id_horario' => 'required'
    ];

    public function mount() {
        $this->disciplinas = Disciplina::pluck('nombre', 'id')->toArray();
        $this->entrenadores = Empleado::All()->where('tipo_empleado', 'E');
        $this->horarios = Horario::All();
    }

    public function cancelar()
    {
        $this->emit('cancelarCreacion');
    }

    public function guardarHorario() 
    {
        $this->validate();

        Grupo::create([
            'nombre' => $this->nombre,
            'nro_integrantes' => $this->nro_integrantes,
            'id_disciplina' => $this->id_disciplina,
            'id_entrenador' => $this->id_entrenador,
            'id_horario' => $this->id_horario
        ]);

        $this->emitTo('horario.show', 'render');
        $this->emit('registroGuardado');

    }

    public function render()
    {
        return view('livewire.grupo.create');
    }
}
