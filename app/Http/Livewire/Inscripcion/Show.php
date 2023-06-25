<?php

namespace App\Http\Livewire\Inscripcion;

use App\Models\Inscripcion;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado;
    public $vistaVer = false;
    public $vistaEditar = false;
    public $vistaCrear = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarInscripcion' => 'eliminarInscripcion'
    ];

    public function seleccionarInscripcion($registroId, $vista)
    {
        $this->registroSeleccionado = Inscripcion::findOrFail($registroId);

        if ($vista === 'ver') {
            $this->vistaVer = true;
            $this->emit('verRegistro', $this->registroSeleccionado);
        } elseif ('editar') {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        }
    }

    public function eliminarInscripcion($registroId)
    {
        // Buscar el registro en base al ID
        $inscripcion = Inscripcion::find($registroId);
        if ($inscripcion) {
            $grupos = $inscripcion->grupos;
            
            // Eliminar la inscripción y la relación en cascada
            $inscripcion->delete();

            // Actualizar el número de integrantes en cada grupo
            foreach ($grupos as $grupo) {
                $grupo->decrement('nro_integrantes');
            }

            $this->registroSeleccionado = null;
        } 
    }

    public function obtenerFechaInscripcion($registroId) {
        $fecha_inscripcion = Inscripcion::find($registroId);
        $fecha = Carbon::parse($fecha_inscripcion->fecha_inscripcion)->format('d/m/Y');
        $hora = Carbon::parse($fecha_inscripcion->fecha_inscripcion)->format('H:i A');
        return $fecha . ' - ' . $hora;
    }

    public function obtenerFechaInicio($registroId) {
        $fecha = Inscripcion::find($registroId);
        $fecha = Carbon::parse($fecha->fecha_inicio)->format('d/m/Y');
        return $fecha;
    }

    public function agregarNuevo()
    {
        $this->vistaCrear = true;
    }

    public function cerrarVista()
    {
        $this->vistaCrear = false;
        $this->vistaEditar = false;
        $this->vistaVer = false;
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
        $inscripciones = Inscripcion::where('id', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.inscripcion.show', ['inscripciones' => $inscripciones]);
    }

}
