<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Models\Horario;
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

    public function editarRegistro($registroSeleccionado)
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
        $this->emit('cancelarEdicion');
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
        $registro->save();
    
        $this->emitTo('horario.show','render');
        $this->emit('registroActualizado');

        // Limpiar la propiedad $registroSeleccionado
        $this->registroSeleccionado = null;

    }

    public function render()
    {
        return view('livewire.grupo.edit');
    }
}
