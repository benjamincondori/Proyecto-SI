<?php

namespace App\Http\Livewire\Inscripcion;

use App\Models\Inscripcion;
use Carbon\Carbon;
use Livewire\Component;

class View extends Component
{
    public $id_cliente, $nombre, $apellido, $fechaInscripcion, $fechaInicio, $fechaVencimiento;
    public $paquete, $duracion, $diasRestantes, $estado;

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $inscripcion = Inscripcion::find($registroSeleccionado['id']);
        $this->id_cliente = $inscripcion->cliente->id;
        $this->nombre = $inscripcion->cliente->nombres;
        $this->apellido = $inscripcion->cliente->apellidos;
        $this->fechaInscripcion = $inscripcion->fecha_inscripcion;
        $this->fechaInicio = $inscripcion->detalle->fecha_inicio;
        $this->fechaVencimiento = $inscripcion->detalle->fecha_vencimiento;
        $this->paquete = $inscripcion->paquete->nombre;
        $this->duracion = $inscripcion->duracion->nombre;
        $this->actualizarDiasRestantes($inscripcion);
        $this->verificarInscripcion($inscripcion);
        $this->diasRestantes = $inscripcion->detalle->dias_restantes;
        $this->estado = $inscripcion->detalle->estado;
    }

    public function actualizarDiasRestantes($inscripcion) {
        $detalleInscripcion = $inscripcion->detalle;
        $diasRestantes = $this->calcularDiasRestantes($detalleInscripcion->fecha_vencimiento);
        $detalleInscripcion->dias_restantes = $diasRestantes;
        $detalleInscripcion->save();
    }

    public function calcularDiasRestantes($fecha) {
        $hoy = Carbon::now();
        $fechaFin = Carbon::parse($fecha);
        $diasRestantes = $hoy->diffInDays($fechaFin, false);
        return ($diasRestantes > 0) ? $diasRestantes : 0;
    }

    public function verificarInscripcion($inscripcion) {
        $detalleInscripcion = $inscripcion->detalle;
        $fechaFin = Carbon::parse($detalleInscripcion->fecha_vencimiento);
        $hoy = Carbon::now();
        if ($hoy > $fechaFin) {
            // Cambiar el estado del alquiler a "vencido"
            $detalleInscripcion->estado = 0;
            $detalleInscripcion->save();

            $grupos = $inscripcion->grupos;

            // Actualizar el número de integrantes en cada grupo
            foreach ($grupos as $grupo) {
                $grupo->decrement('nro_integrantes');
            }
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
        return view('livewire.inscripcion.view');
    }
}
