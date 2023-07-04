<?php

namespace App\Http\Livewire\AsignarMaquina;

use App\Models\Maquina;
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
    public $sort = 'codigo';
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarMaquina' => 'eliminarMaquina'
    ];

    public function seleccionarMaquina(Maquina $maquina)
    {
        if (verificarPermiso('Maquina_Editar')) {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $maquina);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarMaquina($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Maquina::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();

            $descripcion = 'Se eliminó la máquina asignada con CÓDIGO: '.$registro->codigo.' de la sección de '.$registro->seccion->nombre;
            registrarBitacora($descripcion);

            $this->registroSeleccionado = null;
        }
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Maquina_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Maquina_Eliminar');
    }

    public function render()
    {
        $maquinas = Maquina::where('codigo', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.asignar-maquina.show', ['maquinas' => $maquinas]);
    }
}
