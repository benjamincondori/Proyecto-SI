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

    public $registroSeleccionado, $verificarPermiso;
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
            if (verificarPermiso('Inscripcion_Ver')) {
                $this->vistaVer = true;
                $this->emit('verRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        } elseif ('editar') {
            if (verificarPermiso('Inscripcion_Editar')) {
                $this->vistaEditar = true;
                $this->emit('editarRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
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
        if (verificarPermiso('Inscripcion_Crear')) {
            $this->vistaCrear = true;
        } else {
            $this->emit('accesoDenegado');
        }
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

    public function mount() {
        $this->verificarPermiso = verificarPermiso('Inscripcion_Eliminar');
    }

    public function render()
    {
        $inscripciones = Inscripcion::where('id', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.inscripcion.show', ['inscripciones' => $inscripciones]);
    }

}
