<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Grupo;
use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public $id_grupo, $nombre, $nro_integrantes, $max_integrantes, $id_disciplina, $id_entrenador, $id_horario;
    public $disciplinas, $entrenadores, $horarios;

    protected $rules = [
        'nombre' => 'required|max:40',
        'nro_integrantes' => 'required',
        'max_integrantes' => 'required',
        'id_disciplina' => 'required',
        'id_entrenador' => 'required',
        'id_horario' => 'required'
    ];

    protected $validationAttributes = [
        'max_integrantes' => 'nro máximo integrantes',
        'id_disciplina' => 'disciplina',
        'id_entrenador' => 'entrenador',
        'id_horario' => 'horario'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function obtenerCapacidad($idDisciplina) {
        $disciplina = Disciplina::findOrFail($idDisciplina);
        return $disciplina->seccion;
    }

    public function updatedIdDisciplina() {
        $this->entrenadores = $this->obtenerEntrenadores($this->id_disciplina);
    }

    public function obtenerNombreEntrenador($idEntrenador) {
        $datosEntrenador = Empleado::findOrFail($idEntrenador);
        return $datosEntrenador->nombres.' '.$datosEntrenador->apellidos;
    }

    public function obtenerEntrenadores($idDisciplina) {
        $entrenadores = Entrenador::whereHas('disciplinas', function ($query) use ($idDisciplina) {
            $query->where('id_disciplina', $idDisciplina);
        })->get();
        
        return $entrenadores;
    }

    public function mount() {
        $this->disciplinas = Disciplina::pluck('nombre', 'id')->toArray();
        $this->entrenadores = Empleado::all()->where('tipo_empleado', 'E');
        $this->horarios = Horario::all();
        $this->nro_integrantes = 0;
    }

    public function cancelar()
    {
        $this->emitTo('grupo.show', 'cerrarVista');
    }

    public function guardarGrupo() 
    {
        $this->validate();

        try {
            $grupo = new Grupo;
            $grupo->nombre = $this->nombre;
            $grupo->nro_integrantes = $this->nro_integrantes;
            $grupo->id_disciplina = $this->id_disciplina;
            $grupo->id_entrenador = $this->id_entrenador;
            $grupo->id_horario = $this->id_horario;
            $grupo->max_integrantes = $this->max_integrantes;
        
            // dd($this->obtenerCapacidad($this->id_disciplina));

            $grupo->save();

            $descripcion = 'Se creó el grupo con ID: '.$grupo->id.' - '.$grupo->nombre;
            registrarBitacora($descripcion);

            $this->emitTo('grupo.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.grupo.create');
    }
}
