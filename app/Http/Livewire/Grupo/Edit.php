<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Grupo;
use App\Models\Horario;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;
    public $disciplinas, $entrenadores, $horarios;
    public $id_entrenador, $id_disciplina;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:40',
        'id_disciplina' => 'required',
        'id_entrenador' => 'required',
        'registroSeleccionado.id_horario' => 'required'
    ];

    protected $validationAttributes = [
        'id_disciplina' => 'disciplina',
        'id_entrenador' => 'entrenador',
        'registroSeleccionado.id_horario' => 'horario'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedIdDisciplina() {
        $this->entrenadores = $this->obtenerEntrenadores($this->id_disciplina, $this->id_entrenador);
    }

    public function obtenerNombreEntrenador($idEntrenador) {
        $datosEntrenador = Empleado::findOrFail($idEntrenador);
        return $datosEntrenador->nombres.' '.$datosEntrenador->apellidos;
    }

    public function obtenerEntrenadores($idDisciplina, $idEntrenador) {
        $entrenadores = Entrenador::whereHas('disciplinas', function ($query) use ($idDisciplina) {
            $query->where('id_disciplina', $idDisciplina);
        })
        ->orWhere('id', $idEntrenador)
        ->get();

        return $entrenadores;
    }

    public function editarRegistro(Grupo $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->id_entrenador = $this->registroSeleccionado['id_entrenador'];
        $this->id_disciplina = $this->registroSeleccionado['id_disciplina'];
        $this->entrenadores = $this->obtenerEntrenadores($this->id_disciplina, $this->id_entrenador);
    }

    public function mount() {
        $this->disciplinas = Disciplina::pluck('nombre', 'id')->toArray();
        $this->entrenadores = Empleado::All()->where('tipo_empleado', 'E');
        $this->horarios = Horario::All();
    }

    public function cancelar()
    {
        $this->emitTo('grupo.show','cerrarVista');
    }

    public function actualizarGrupo() 
    {
        $this->validate();
    
        try {
            // Realizar la actualización del registro seleccionado
            $registro = Grupo::find($this->registroSeleccionado['id']);

            $registro->nombre = $this->registroSeleccionado['nombre'];
            $registro->id_disciplina = $this->id_disciplina;
            $registro->id_entrenador = $this->id_entrenador;
            $registro->id_horario = $this->registroSeleccionado['id_horario'];

            $registro->save();
            $this->emitTo('grupo.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.grupo.edit');
    }
}
