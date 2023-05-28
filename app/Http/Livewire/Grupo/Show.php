<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Grupo;
use App\Models\Horario;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $grupos, $buscar, $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarGrupo' => 'eliminarGrupo'
    ];

    public function seleccionarGrupo($registroId)
    {
        $this->registroSeleccionado = Grupo::findOrFail($registroId);
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $this->registroSeleccionado);
    }

    public function eliminarGrupo($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Grupo::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            $this->registroSeleccionado = null;
            $this->mount();
        }
    }

    public function agregarNuevo()
    {
        $this->vistaCrear = true;
    }

    public function cerrarVista()
    {
        $this->vistaCrear = false;
        $this->vistaEditar = false;
        $this->mount();
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
        $horario = Horario::find($idHorario);
        $horaInicio = Carbon::parse($horario->hora_inicio)->format('H:i A');
        $horaFin = Carbon::parse($horario->hora_fin)->format('H:i A');
        return $horaInicio.' - '.$horaFin;
    }

    public function buscar()
    {
        $this->grupos = Grupo::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

        $this->render();
    }

    public function render()
    {
        return view('livewire.grupo.show');
    }
}
