<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Grupo;
use App\Models\Horario;
use Livewire\Component;

class Show extends Component
{
    public $grupos;
    public $vistaFormulario = false;
    public $mostrarFormularioEditar = false;
    public $registroSeleccionado;

    protected $listeners = [
        'registroGuardado' => 'volverATabla',
        'cancelarCreacion' => 'volverATabla',
        'cancelarEdicion' => 'volverATabla',
        'registroActualizado' => 'volverATabla',
        'render' => 'render'
    ];

    public function seleccionarGrupo($registroId)
    {
        $this->registroSeleccionado = Grupo::findOrFail($registroId);
        $this->emit('editarRegistro', $this->registroSeleccionado);

        $this->mostrarFormularioEditar = true;
    }

    public function eliminarRegistro($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Grupo::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            
            $this->emitTo('Grupo','render');
        }
    }

    public function agregarNuevo()
    {
        $this->vistaFormulario = true;
    }

    public function volverATabla()
    {
        $this->vistaFormulario = false;
        $this->mostrarFormularioEditar = false;
    }

    public function mount()
    {
        $this->grupos = Grupo::All();
    }

    public function obtenerNombreDisciplina($idDisciplina)
    {
        $disciplina = Disciplina::find($idDisciplina);
        return $disciplina ? $disciplina->nombre : '';
    }

    public function obtenerNombreEntrenador($idEntrenador)
    {
        $entrenador = Empleado::find($idEntrenador)->nombres;
        $entrenador .= ' '.Empleado::find($idEntrenador)->apellidos;
        return $entrenador;
    }

    public function obtenerNombreHorario($idHorario)
    {
        $horario = Horario::find($idHorario)->hora_inicio;
        $horario .= ' - '.Horario::find($idHorario)->hora_fin;
        return $horario;
    }

    public function render()
    {
        return view('livewire.grupo.show');
    }
}
