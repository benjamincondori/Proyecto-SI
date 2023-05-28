<?php

namespace App\Http\Livewire\TipoMaquina;

use Livewire\Component;
use App\Models\Tipo_Maquina;

class Show extends Component
{
    public $maquinas, $buscar, $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarMaquina' => 'eliminarMaquina'
    ];

    public function seleccionarMaquina($registroId)
    {
        $this->registroSeleccionado = Tipo_Maquina::findOrFail($registroId);
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $this->registroSeleccionado);
    }

    public function eliminarMaquina($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Tipo_Maquina::find($registroId);

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
        $this->maquinas = Tipo_Maquina::All();
    }

    public function buscar()
    {
        $this->maquinas = Tipo_Maquina::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orWhere('descripcion', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

        $this->render();
    }

    public function render()
    {
        return view('livewire.tipo-maquina.show');
    }
}
