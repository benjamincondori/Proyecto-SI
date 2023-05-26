<?php

namespace App\Http\Livewire\TipoMaquina;

use Livewire\Component;
use App\Models\Tipo_Maquina;

class Show extends Component
{
    public $maquinas;
    public $vistaFormulario = false;
    public $mostrarFormularioEditar = false;
    public $registroSeleccionado;

    protected $listeners = [
        'registroGuardado' => 'volverATabla',
        'cancelarCreacion' => 'volverATabla',
        'cancelarEdicion' => 'volverATabla',
        'registroActualizado' => 'volverATabla',
        'render' => 'render'
    ];

    public function seleccionarMaquina($registroId)
    {
        $this->registroSeleccionado = Tipo_Maquina::findOrFail($registroId);
        $this->emit('editarRegistro', $this->registroSeleccionado);

        $this->mostrarFormularioEditar = true;
    }

    public function eliminarRegistro($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Tipo_Maquina::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            
            $this->emitTo('TipoMaquina','render');
        }
    }

    public function agregarNuevo()
    {
        $this->vistaFormulario = true;
    }

    public function volverATabla()
    {
        $this->vistaFormulario = false;
        $this->mostrarFormularioEditar = false;
    }

    public function mount()
    {
        $this->maquinas = Tipo_Maquina::All();
    }

    public function render()
    {
        return view('livewire.tipo-maquina.show');
    }
}
