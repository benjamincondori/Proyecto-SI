<?php

namespace App\Http\Livewire\Entrenador;

use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado, $verificarPermiso;
    public $vistaVer = false;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarEntrenador' => 'eliminarEntrenador'
    ];

    public function seleccionarEntrenador($registroId, $vista)
    {
        $this->registroSeleccionado = Empleado::findOrFail($registroId);

        if ($vista === 'ver') {
            if (verificarPermiso('Entrenador_Ver')) {
                $this->vistaVer = true;
                $this->emit('verRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        } elseif ('editar') {
            if (verificarPermiso('Entrenador_Editar')) {
                $this->vistaEditar = true;
                $this->emit('editarRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        }
    }

    public function eliminarEntrenador($registroId)
    {
        // Buscar el registro en base al nro
        $registro = Empleado::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            $this->registroSeleccionado = null;
        }
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Entrenador_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Entrenador_Eliminar');
    }

    public function render()
    {
        $entrenadores = Empleado::where('tipo_empleado', 'E')
            ->where(function ($query) {
                $buscar = '%' . $this->buscar . '%';
                $query->where('id', 'like', $buscar)
                    ->orWhere('ci', 'like', $buscar)
                    ->orWhere('nombres', 'like', $buscar)
                    ->orWhere('apellidos', 'like', $buscar)
                    ->orWhere('email', 'like', $buscar);
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.entrenador.show', ['entrenadores' => $entrenadores]);
    }
                
}
