<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Models\Horario;
use Carbon\Carbon;
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

    protected $validationAttributes = [
        'id_disciplina' => 'disciplina',
        'id_entrenador' => 'entrenador',
        'id_horario' => 'horario'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function mount() {
        $this->disciplinas = Disciplina::pluck('nombre', 'id')->toArray();
        $this->entrenadores = Empleado::All()->where('tipo_empleado', 'E');
        $this->horarios = Horario::All();
    }

    public function cancelar()
    {
        $this->emitTo('grupo.show', 'cerrarVista');
    }

    public function guardarGrupo() 
    {
        $this->validate();

        $grupo = new Grupo;
        $grupo->nombre = $this->nombre;
        $grupo->nro_integrantes = $this->nro_integrantes;
        $grupo->id_disciplina = $this->id_disciplina;
        $grupo->id_entrenador = $this->id_entrenador;
        $grupo->id_horario = $this->id_horario;
        
        try {
            $grupo->save();
            $this->emitTo('grupo.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $this->emit('error');
        }
    }

    public function render()
    {
        $this->dispatchBrowserEvent('bootstrapSelect');

        return view('livewire.grupo.create');
    }
}
