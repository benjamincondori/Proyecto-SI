<?php

namespace App\Http\Livewire\Alquiler;

use App\Models\Alquiler;
use App\Models\Casillero;
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
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarAlquiler' => 'eliminarAlquiler'
    ];

    public function seleccionarAlquiler($registroId, $vista)
    {
        $this->registroSeleccionado = Alquiler::findOrFail($registroId);

        if ($vista === 'ver') {
            if (verificarPermiso('Alquiler_Ver')) {
                $this->vistaVer = true;
                $this->emit('verRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        } elseif ('editar') {
            if (verificarPermiso('Alquiler_Editar')) {
                $this->vistaEditar = true;
                $this->emit('editarRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        }
    }

    public function eliminarAlquiler($registroId)
    {
        $alquiler = Alquiler::find($registroId);

        if (is_null($alquiler->estado)) {
            $eliminado = $alquiler->delete();
            $alquiler->pago->delete();
            
            if ($eliminado) {
                $casillero = Casillero::findOrFail($alquiler->id_casillero);
                $casillero->estado = 1;
                $casillero->save();

                $descripcion = 'Se eliminó el alquiler con ID: '.$alquiler->id;
                registrarBitacora($descripcion);
    
                $this->registroSeleccionado = null;
            }
        }
    }

    public function obtenerFechaAlquiler($registroId) {
        $fecha_alquiler = Alquiler::find($registroId);
        $fecha = Carbon::parse($fecha_alquiler->fecha_alquiler)->format('d/m/Y');
        $hora = Carbon::parse($fecha_alquiler->fecha_alquiler)->format('H:i A');
        return $fecha . ' - ' . $hora;
    }

    public function formatoFecha($fecha) {
        $fecha = Carbon::parse($fecha)->format('d/m/Y');
        return $fecha;
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Alquiler_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Alquiler_Eliminar');
    }

    public function render()
    {
        $alquileres = Alquiler::where('id', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.alquiler.show', ['alquileres' => $alquileres]);
    }
}
