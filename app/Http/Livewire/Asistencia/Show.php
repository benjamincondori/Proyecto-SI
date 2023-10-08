<?php

namespace App\Http\Livewire\Asistencia;

use App\Models\Asistencia;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado, $verificarPermiso;
    public $vistaEditar = false;
    public $vistaCrear = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarRegistro' => 'eliminarRegistro'
    ];

    public function seleccionarRegistro($registroId)
    {
        $this->registroSeleccionado = Asistencia::findOrFail($registroId);

        if (verificarPermiso('Asistencia_Editar')) {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarRegistro($registroId)
    {
        $registro = Asistencia::find($registroId);

        if ($registro) {
            $registro->delete();

            $descripcion = 'Se eliminó el registro de asistencia con ID: '.$registro->id;
            registrarBitacora($descripcion);

            $this->registroSeleccionado = null;
        }
    }

    public function formatoHora($hora) {
        $hora = Carbon::parse($hora)->format('H:i:s A');
        return $hora;
    }

    public function formatoFecha($fecha) {
        $fecha = Carbon::parse($fecha)->format('d/m/Y');
        return $fecha;
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Asistencia_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Asistencia_Eliminar');
    }


    public function render()
    {
        $registros = Asistencia::where('id', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.asistencia.show', ['registros' => $registros]);
    }
}
