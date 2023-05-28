<?php

namespace App\Http\Livewire\Seccion;

use App\Models\Seccion;
use Livewire\Component;

class Show extends Component
{
    public $secciones, $buscar, $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarSeccion' => 'eliminarSeccion'
    ];

    public function seleccionarSeccion($registroId)
    {
        $this->registroSeleccionado = Seccion::findOrFail($registroId);
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $this->registroSeleccionado);
    }

    public function eliminarSeccion($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Seccion::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
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
        $this->secciones = Seccion::All();
    }

    public function buscar()
    {
        $this->secciones = Seccion::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orWhere('descripcion', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

        $this->render();
    }

    public function render()
    {
        return view('livewire.seccion.show');
    }
}
