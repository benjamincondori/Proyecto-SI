<?php

namespace App\Http\Livewire\AsignarDuracion;

use App\Models\Duracion;
use App\Models\Paquete;
use App\Models\Paquete_Duracion;
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
    public $sort = 'id_paquete';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarAsignacion' => 'eliminarAsignacion'
    ];

    public function seleccionarAsignacion($seleccionado)
    {
        if (verificarPermiso('AsignarDuracion_Editar')) {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $seleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarAsignacion($idPaquete, $idDuracion)
    {
        $paquete = Paquete::findOrFail($idPaquete);

        if ($paquete) {
            $paquete->duraciones()->detach($idDuracion);
        }
    }

    public function formatoMoneda($precio) {
        $formateado = number_format($precio, 2, ',', '.').' Bs';
        return $formateado;
    }

    public function formatoPorcentaje($descuento) {
        $porcentaje = number_format($descuento * 100, 0).'%';
        return $porcentaje;
    }

    public function obtenerNombrePaquete($idPaquete) {
        $paquete = Paquete::findOrFail($idPaquete);
        return $paquete->nombre;
    }

    public function obtenerNombreDuracion($idDuracion) {
        $duracion = Duracion::findOrFail($idDuracion);
        return $duracion->nombre;
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('AsignarDuracion_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('AsignarDuracion_Eliminar');
    }

    public function render()
    {
        $datos = Paquete_Duracion::where('id_paquete', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.asignar-duracion.show', ['datos' => $datos]);
    }
}
