<?php

namespace App\Http\Livewire\Casillero;

use App\Models\Casillero;
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
    public $sort = 'nro';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarCasillero' => 'eliminarCasillero'
    ];

    public function seleccionarCasillero($registroId)
    {
        if (verificarPermiso('Casillero_Editar')) {
            $this->registroSeleccionado = Casillero::findOrFail($registroId);
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function eliminarCasillero($registroId)
    {
        // Buscar el registro en base al nro
        $registro = Casillero::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            $this->registroSeleccionado = null;
        }
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Casillero_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Casillero_Eliminar');
    }

    public function render()
    {
        $casilleros = Casillero::where('nro', 'like', '%' . $this->buscar . '%')
            ->orWhere('tamaño', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.casillero.show', ['casilleros' => $casilleros]);
    }

}
