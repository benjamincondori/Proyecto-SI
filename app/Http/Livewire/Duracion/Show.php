<?php

namespace App\Http\Livewire\Duracion;

use App\Models\Duracion;
use Livewire\Component;

class Show extends Component
{
    public $duraciones, $buscar, $registroSeleccionado;
    public $vistaEditar = false;
    public $vistaCrear = false;
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarDuracion' => 'eliminarDuracion'
    ];

    public function seleccionarPaquete($registroId)
    {
        $this->registroSeleccionado = Duracion::findOrFail($registroId);
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $this->registroSeleccionado);
    }

    public function eliminarDuracion($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Duracion::find($registroId);
        if ($registro) {
            $registro->delete();
            $this->registroSeleccionado = null;
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

        $this->mount();
    }

    public function mount()
    {
        $this->duraciones = Duracion::all();
    }

    public function buscar()
    {
        $this->duraciones = Duracion::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

        $this->render();
    }

    public function render()
    {
        return view('livewire.duracion.show');
    }
}
