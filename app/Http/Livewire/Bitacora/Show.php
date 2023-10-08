<?php

namespace App\Http\Livewire\Bitacora;

use App\Models\Bitacora;
use App\Models\Empleado;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'desc';

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

    public function obtenerNombreUsuario($usuarioId) {
        $usuario = Empleado::findOrFail($usuarioId);
        return $usuario->nombres.' '.$usuario->apellidos;
    }

    public function formatoFecha($fecha) {
        $hora = $fecha;
        $fecha = Carbon::parse($fecha)->format('d/m/Y');
        $hora = Carbon::parse($hora)->format('H:i:s A');
        return $fecha . ' - ' . $hora;
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
        $registros = Bitacora::where('id', 'like', '%' . $this->buscar . '%')
            ->orWhere('id_usuario', 'like', '%' . $this->buscar . '%')
            ->orWhere('descripcion', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.bitacora.show', ['registros' => $registros]);
    }
}
