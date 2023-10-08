<?php

namespace App\Http\Livewire\AsignarInstructor;

use App\Models\Disciplina;
use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Entrenador_Disciplina;
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
    public $sort = 'id_entrenador';
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarAsignacion' => 'eliminarAsignacion'
    ];

    public function seleccionarAsignacion($seleccionado)
    {
        if (verificarPermiso('AsignarInstructor_Editar')) {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $seleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarAsignacion($idEntrenador, $idDisciplina)
    {
        $disciplina = Disciplina::findOrFail($idDisciplina);

        if ($disciplina) {
            $disciplina->entrenadores()->detach($idEntrenador);

            $descripcion = 'Se eliminó el entrenador asignado con ID: '.$idEntrenador.' a la disciplina '.$disciplina->nombre;
            registrarBitacora($descripcion);
        }
    }

    public function obtenerNombreEntrenador($idEntrenador) {
        $datosEntrenador = Empleado::findOrFail($idEntrenador);
        return $datosEntrenador->nombres.' '.$datosEntrenador->apellidos;
    }

    public function obtenerNombreDisciplina($idDisciplina) {
        $datosDisciplina = Disciplina::findOrFail($idDisciplina);
        return $datosDisciplina->nombre;
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('AsignarInstructor_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('AsignarInstructor_Eliminar');
    }

    public function render()
    {
        $datos = Entrenador_Disciplina::where('id_entrenador', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        
        return view('livewire.asignar-instructor.show', ['datos' => $datos]);
    }
}
