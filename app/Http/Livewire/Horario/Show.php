<?php

namespace App\Http\Livewire\Horario;

use App\Models\Horario;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $horarios, $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarHorario' => 'eliminarHorario'
    ];

    public function seleccionarHorario($registroId)
    {
        $this->registroSeleccionado = Horario::findOrFail($registroId);
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $this->registroSeleccionado);
    }

    public function eliminarHorario($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Horario::find($registroId);

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
        $horarios = Horario::all();

        foreach ($horarios as $horario) {
            $horaInicio = Carbon::parse($horario->hora_inicio)->format('H:i A');
            $horaFin = Carbon::parse($horario->hora_fin)->format('H:i A');
            $horario->hora_inicio = $horaInicio;
            $horario->hora_fin = $horaFin;
        }

        $this->horarios = $horarios;
    }

    public function render()
    {
        return view('livewire.horario.show');
    }
}
