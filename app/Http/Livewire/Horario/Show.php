<?php

namespace App\Http\Livewire\Horario;

use Livewire\Component;
use App\Models\Horario;

class Show extends Component
{
    public $horarios;
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

    public function seleccionarHorario($registroId)
    {
        $this->registroSeleccionado = Horario::findOrFail($registroId);
        $this->emit('editarRegistro', $this->registroSeleccionado);

        $this->mostrarFormularioEditar = true;
    }

    public function eliminarRegistro($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Horario::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            
            $this->emitTo('Horario','render');
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
        $this->horarios = Horario::All();
    }

    public function render()
    {
        return view('livewire.horario.show');
    }
}
