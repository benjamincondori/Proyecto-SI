<?php

namespace App\Http\Livewire\AsignarInstructor;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Entrenador;
use Livewire\Component;

class Create extends Component
{
    public $id_entrenador, $id_disciplina;
    public $entrenadores, $disciplinas;

    protected $rules = [
        'id_entrenador' => 'required',
        'id_disciplina' => 'required',
    ];

    protected $validationAttributes = [
        'id_entrenador' => 'entrenador',
        'id_disciplina' => 'disciplina'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('asignar-instructor.show', 'cerrarVista');
    }

    public function guardarAsignacion() 
    {
        $this->validate();

        try {

            $disciplina = Disciplina::findOrFail($this->id_disciplina);

            if ($disciplina) {
                $disciplina->entrenadores()->attach($this->id_entrenador);

                $descripcion = 'Se asignó un nuevo entrenador con ID: '.$this->id_entrenador.' a la disciplina '.$disciplina->nombre;
                registrarBitacora($descripcion);

                $this->emitTo('asignar-instructor.show', 'cerrarVista');
                $this->emit('alert', 'guardado');
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function obtenerNombreEntrenador($idEntrenador) {
        $datosEntrenador = Empleado::findOrFail($idEntrenador);
        return $datosEntrenador->nombres.' '.$datosEntrenador->apellidos;
    }

    public function obtenerDisciplinas($idEntrenador) {
        $disciplinas = Disciplina::whereDoesntHave('entrenadores', function ($query) use ($idEntrenador) {
            $query->where('id_entrenador', $idEntrenador);
        })->get();
        return $disciplinas;
    }

    public function updatedIdEntrenador() {
        $this->disciplinas = $this->obtenerDisciplinas($this->id_entrenador);
    }

    public function mount() {
        $this->entrenadores = Entrenador::all();
        $this->disciplinas = Disciplina::all();
    }

    public function render()
    {
        return view('livewire.asignar-instructor.create');
    }
}
