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

    public $registroSeleccionado, $verificarPermiso;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarUsuario' => 'eliminarUsuario'
    ];

    public function seleccionarUsuario($registroId)
    {
        if (verificarPermiso('Usuario_Editar')) {
            $this->registroSeleccionado = Usuario::findOrFail($registroId);
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarUsuario($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Usuario::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();

            $descripcion = 'Se eliminó el usuario con ID: '.$registro->id;
            registrarBitacora($descripcion);

            $this->registroSeleccionado = null;
        }
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Usuario_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Usuario_Eliminar');
    }

    public function render()
    {
        $empleados = Empleado::join('USUARIO', 'EMPLEADO.id_usuario', '=', 'USUARIO.id')
            ->join('ADMINISTRATIVO', 'EMPLEADO.id', '=', 'ADMINISTRATIVO.id')
            ->where('EMPLEADO.id', 'like', '%' . $this->buscar . '%')
            ->orWhere('EMPLEADO.email', 'like', '%' . $this->buscar . '%')
            ->orWhere('EMPLEADO.nombres', 'like', '%' . $this->buscar . '%')
            ->orWhere('EMPLEADO.apellidos', 'like', '%' . $this->buscar . '%')
            ->orderBy('EMPLEADO.'.$this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.usuario.show', ['empleados' => $empleados]);
    }
}
