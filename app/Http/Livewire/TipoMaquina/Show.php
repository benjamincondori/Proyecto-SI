<?php

namespace App\Http\Livewire\TipoMaquina;

use Livewire\Component;
use App\Models\Tipo_Maquina;
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
        'eliminarMaquina' => 'eliminarMaquina'
    ];

    protected $queryString = [
        'cant' => ['except' => '10']
    ];

    public function seleccionarMaquina(Tipo_Maquina $maquina)
    {
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $maquina);
    }

    public function eliminarMaquina($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Tipo_Maquina::find($registroId);

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

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        $maquinas = Tipo_Maquina::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.tipo-maquina.show', ['maquinas' => $maquinas]);
    }
}
