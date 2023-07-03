<?php

namespace App\Http\Livewire\AsignarInstructor;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Entrenador;
use Livewire\Component;

class Edit extends Component
{
    public  $registroSeleccionado, $id_entrenador, $id_disciplina;
    public $entrenadores, $disciplinas;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'id_entrenador' => 'required',
        'id_disciplina' => 'required'
    ];

    protected $validationAttributes = [
        'id_entrenador' => 'entrenador',
        'id_disciplina' => 'disciplina'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->id_entrenador = $this->registroSeleccionado['id_entrenador'];
        $this->id_disciplina = $this->registroSeleccionado['id_disciplina'];
        $this->disciplinas = $this->obtenerDisciplinas($this->id_entrenador, $this->id_disciplina);
    }

    public function cancelar()
    {
        $this->emitTo('asignar-instructor.show','cerrarVista');
    }

    public function obtenerNombreEntrenador($idEntrenador) {
        $datosEntrenador = Empleado::findOrFail($idEntrenador);
        return $datosEntrenador->nombres.' '.$datosEntrenador->apellidos;
    }

    public function obtenerDisciplinas($idEntrenador, $idDisciplina) {
        $disciplinas = Disciplina::whereDoesntHave('entrenadores', function ($query) use ($idEntrenador) {
            $query->where('id_entrenador', $idEntrenador);
        })
        ->orWhere('id', $idDisciplina)
        ->get();

        return $disciplinas;
    }

    public function actualizarAsignacion() 
    {
        $this->validate();
    
        try {
            $disciplinaAnterior = Disciplina::findOrFail($this->registroSeleccionado['id_disciplina']);
            $disciplina = Disciplina::findOrFail($this->id_disciplina);

            if ($disciplina) {
                $disciplinaAnterior->entrenadores()->detach($this->id_entrenador);
                $disciplina->entrenadores()->attach($this->id_entrenador);

                $this->emitTo('asignar-instructor.show', 'cerrarVista');
                $this->emit('alert', 'guardado');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function updatedIdEntrenador() {
        $this->disciplinas = $this->obtenerDisciplinas($this->id_entrenador, $this->id_disciplina);
    }

    public function mount() {
        $this->entrenadores = Entrenador::all();
        $this->disciplinas = Disciplina::all();
    }

    public function render()
    {
        return view('livewire.asignar-instructor.edit');
    }
}
