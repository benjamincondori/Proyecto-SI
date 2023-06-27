<?php

namespace App\Http\Livewire\Horario;

use App\Models\Horario;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado, $verificarPermiso;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarHorario' => 'eliminarHorario'
    ];

    public function seleccionarHorario($registroId)
    {
        if (verificarPermiso('Horario_Editar')) {
            $this->registroSeleccionado = Horario::findOrFail($registroId);
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarHorario($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Horario::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            $this->registroSeleccionado = null;
        }
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Horario_Crear')) {
            $this->vistaCrear = true;
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function cerrarVista()
    {
        $this->vistaCrear = false;
        $this->vistaEditar = false;
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

    public function mount() {
        $this->verificarPermiso = verificarPermiso('Horario_Eliminar');
    }

    public function render()
    {
        $horarios = Horario::where('descripcion', 'like', '%' . $this->buscar . '%')
            ->orWhere('hora_inicio', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        foreach ($horarios as $horario) {
            $horaInicio = Carbon::parse($horario->hora_inicio)->format('H:i A');
            $horaFin = Carbon::parse($horario->hora_fin)->format('H:i A');
            $horario->hora_inicio = $horaInicio;
            $horario->hora_fin = $horaFin;
        }

        return view('livewire.horario.show', ['horarios' => $horarios]);
    }
}
