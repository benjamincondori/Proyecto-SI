<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado, $verificarPermiso;
    public $vistaVer = false;
    public $vistaEditar = false;
    public $vistaCrear = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarPaquete' => 'eliminarPaquete'
    ];

    public function seleccionarPaquete($registroId, $vista)
    {
        $this->registroSeleccionado = Paquete::findOrFail($registroId);

        if ($vista === 'ver') {
            if (verificarPermiso('Paquete_Ver')) {
                $this->vistaVer = true;
                $this->emit('verRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        } elseif ('editar') {
            if (verificarPermiso('Paquete_Editar')) {
                $this->vistaEditar = true;
                $this->emit('editarRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        }
    }

    public function eliminarPaquete($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Paquete::find($registroId);
        if ($registro) {
            $registro->delete();

            $descripcion = 'Se eliminó el paquete con ID: '.$registro->id;
            registrarBitacora($descripcion);

            $this->registroSeleccionado = null;
        } 
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('Paquete_Crear')) {
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
        $this->verificarPermiso = verificarPermiso('Paquete_Eliminar');
    }

    public function render()
    {
        $paquetes = Paquete::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.paquete.show', ['paquetes' => $paquetes]);
    }
}
