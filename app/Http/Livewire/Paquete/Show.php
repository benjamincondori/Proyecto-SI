<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;

class Show extends Component
{
    public $paquetes, $buscar, $registroSeleccionado;
    public $vistaVer = false;
    public $vistaEditar = false;
    public $vistaCrear = false;
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
            $this->mount();
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

        $this->mount();
    }

    public function mount()
    {
        $this->paquetes = Paquete::all();
    }

    // public function obtenerNombreSeccion($idSeccion)
    // {
    //     $seccion = Seccion::find($idSeccion);
    //     return $seccion ? $seccion->nombre : '';
    // }

    public function buscar()
    {
        $this->paquetes = Paquete::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orWhere('descripcion', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

        $this->render();
    }

    public function render()
    {
        return view('livewire.paquete.show');
    }
}
