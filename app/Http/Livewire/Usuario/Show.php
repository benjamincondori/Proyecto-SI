<?php

namespace App\Http\Livewire\Usuario;

use App\Models\Empleado;
use App\Models\Usuario;
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
        'eliminarUsuario' => 'eliminarUsuario'
    ];

    public function seleccionarUsuario($registroId)
    {
        $this->registroSeleccionado = Usuario::findOrFail($registroId);
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $this->registroSeleccionado);
    }

    public function eliminarUsuario($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Usuario::find($registroId);

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
        $empleados = Empleado::join('usuario', 'empleado.id_usuario', '=', 'usuario.id')
            ->join('administrativo', 'empleado.id', '=', 'administrativo.id')
            ->where('empleado.id', 'like', '%' . $this->buscar . '%')
            ->orWhere('empleado.email', 'like', '%' . $this->buscar . '%')
            ->orWhere('empleado.nombres', 'like', '%' . $this->buscar . '%')
            ->orWhere('empleado.apellidos', 'like', '%' . $this->buscar . '%')
            ->orderBy('empleado.'.$this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.usuario.show', ['empleados' => $empleados]);
    }
}
