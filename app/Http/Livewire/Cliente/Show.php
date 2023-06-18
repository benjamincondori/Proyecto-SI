<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado;
    public $vistaVer = false;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarCliente' => 'eliminarCliente',
    ];

    public function seleccionarCliente($registroId, $vista)
    {
        $this->registroSeleccionado = Cliente::findOrFail($registroId);

        if ($vista === 'ver') {
            $this->vistaVer = true;
            $this->emit('verRegistro', $this->registroSeleccionado);
        } elseif ('editar') {
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        }
    }

    public function eliminarCliente($registroId)
    {
        // Buscar el registro en base al nro
        $registro = Cliente::find($registroId);

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
        $clientes = Cliente::where('id', 'like', '%' . $this->buscar . '%')
            ->orWhere('ci', 'like', '%' . $this->buscar . '%')
            ->orWhere('nombres', 'like', '%' . $this->buscar . '%')
            ->orWhere('apellidos', 'like', '%' . $this->buscar . '%')
            ->orWhere('email', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.cliente.show', ['clientes' => $clientes]);
    }

}
