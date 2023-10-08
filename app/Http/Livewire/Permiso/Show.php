<?php

namespace App\Http\Livewire\Permiso;

use App\Models\Permiso;
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
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarPermiso' => 'eliminarPermiso'
    ];

    public function seleccionarPermiso($registroId)
    {
        if (verificarPermiso('Permiso_Editar')) {
            $this->registroSeleccionado = Permiso::findOrFail($registroId);
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarPermiso($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Permiso::findOrFail($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();

            $descripcion = 'Se eliminó el permiso con ID: '.$registro->id.' - '.$registro->nombre;
            registrarBitacora($descripcion);

            $this->registroSeleccionado = null;
        }
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Permiso_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Permiso_Eliminar');
    }

    public function render()
    {
        $permisos = Permiso::where('id', 'like', '%' . $this->buscar . '%')
            ->orWhere('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.permiso.show', ['permisos' => $permisos]);
    }
}
