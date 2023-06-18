<?php

namespace App\Http\Livewire\Grupo;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Grupo;
use App\Models\Horario;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar = '';
    public $cant = '10';
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

    public function order($sort) 
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function updatedCant()
    {
        $this->resetPage();
        $this->gotoPage(1);
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        $grupos = Grupo::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.grupo.show', ['grupos' => $grupos]);
    }
}
