<?php

namespace App\Http\Livewire\Alquiler;

use App\Models\Alquiler;
use Carbon\Carbon;
use Livewire\Component;

class View extends Component
{
    public $nombre, $apellido, $fechaAlquiler, $fechaInicio, $fechaFin;
    public $nroCasillero, $diasDuracion, $diasRestantes, $estado;

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $alquiler = Alquiler::find($registroSeleccionado['id']);
        $this->nombre = $alquiler->cliente->nombres;
        $this->apellido = $alquiler->cliente->apellidos;
        $this->fechaAlquiler = $alquiler->fecha_alquiler;
        $this->fechaInicio = $alquiler->fecha_inicio;
        $this->fechaFin = $alquiler->fecha_fin;
        $this->nroCasillero = $alquiler->casillero->nro;
        $this->diasDuracion = $alquiler->dias_duracion;
        $this->diasRestantes = $this->calcularDiasRestantes($this->fechaFin);
        $this->verificarAlquiler($alquiler->id);
        $this->estado = $alquiler->estado;
    }

    public function calcularDiasRestantes($fecha) {
        $hoy = Carbon::now();
        $fechaFin = Carbon::parse($fecha);
        $diasRestantes = $hoy->diffInDays($fechaFin, false);
        return ($diasRestantes > 0) ? $diasRestantes : 0;
    }

    public function verificarAlquiler($idAlquiler) {
        $alquiler = Alquiler::findOrFail($idAlquiler);
        $fechaFin = Carbon::parse($alquiler->fecha_fin);
        $hoy = Carbon::now();
        if ($hoy > $fechaFin) {
            // Cambiar el estado del alquiler a "vencido"
            $alquiler->estado = 0;
            $alquiler->save();

            $casillero = $alquiler->casillero;
            $casillero->estado = 1;
            $casillero->save();
        }
    }

    public function formatoFechaHora($fecha) {
        $fechaHora = $fecha;
        $fecha = Carbon::parse($fechaHora)->format('d/m/Y');
        $hora = Carbon::parse($fechaHora)->format('H:i:s A');
        return $fecha.' - '.$hora;
    }

    public function formatoFecha($fecha) {
        $fechaFormateada = Carbon::parse($fecha)->format('d/m/Y');
        return $fechaFormateada;
    }

    public function cancelar()
    {
        $this->emit('cerrarVista');
    }

    public function render()
    {
        return view('livewire.alquiler.view');
    }
}
