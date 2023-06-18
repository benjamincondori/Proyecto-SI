<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Models\Horario;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;
    public $disciplinas, $entrenadores, $horarios;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:40',
        'registroSeleccionado.nro_integrantes' => 'required',
        'registroSeleccionado.id_disciplina' => 'required',
        'registroSeleccionado.id_entrenador' => 'required',
        'registroSeleccionado.id_horario' => 'required'
    ];

    protected $validationAttributes = [
        'registroSeleccionado.id_disciplina' => 'disciplina',
        'registroSeleccionado.id_entrenador' => 'entrenador',
        'registroSeleccionado.id_horario' => 'horario'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro(Grupo $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
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
    
        // Realizar la actualización del registro seleccionado
        $registro = Grupo::find($this->registroSeleccionado['id']);

        $registro->nombre = $this->registroSeleccionado['nombre'];
        $registro->nro_integrantes = $this->registroSeleccionado['nro_integrantes'];
        $registro->id_disciplina = $this->registroSeleccionado['id_disciplina'];
        $registro->id_entrenador = $this->registroSeleccionado['id_entrenador'];
        $registro->id_horario = $this->registroSeleccionado['id_horario'];

        try {
            $registro->save();
            $this->emitTo('grupo.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $this->emit('error');
        }
    }

    public function render()
    {
        return view('livewire.grupo.edit');
    }
}
