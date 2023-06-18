<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado;
    public $vistaVer = false;
    public $vistaEditar = false;
    public $vistaCrear = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarPaquete' => 'eliminarPaquete'
    ];

    public function seleccionarPaquete($registroId, $vista)
    {
        $this->registroSeleccionado = Paquete::findOrFail($registroId);

        if ($vista === 'ver') {
            $this->vistaVer = true;
            $this->emit('verRegistro', $this->registroSeleccionado);
        } elseif ('editar') {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        }
    }

    public function eliminarPaquete($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Paquete::find($registroId);
        if ($registro) {
            $registro->delete();
            $this->registroSeleccionado = null;
            // $this->mount();
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

    public function render()
    {
        $paquetes = Paquete::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.paquete.show', ['paquetes' => $paquetes]);
    }
}
