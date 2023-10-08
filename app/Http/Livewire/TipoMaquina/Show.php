<?php

namespace App\Http\Livewire\TipoMaquina;

use Livewire\Component;
use App\Models\Tipo_Maquina;
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
        'eliminarTipoMaquina' => 'eliminarTipoMaquina'
    ];

    public function seleccionarTipoMaquina(Tipo_Maquina $maquina)
    {
        if (verificarPermiso('Maquina_Editar')) {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $maquina);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarTipoMaquina($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Tipo_Maquina::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();

            $descripcion = 'Se eliminó la máquina con ID: '.$registro->id;
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
        $maquinas = Tipo_Maquina::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.tipo-maquina.show', ['maquinas' => $maquinas]);
    }
}
