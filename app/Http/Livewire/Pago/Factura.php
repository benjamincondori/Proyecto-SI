<?php

namespace App\Http\Livewire\Pago;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Pago;
use App\Models\Paquete_Duracion;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Factura extends Component
{
    public $registroSeleccionado;
    public $usuario, $cliente, $pago, $factura, $paquete, $duracion, $casillero;
    public $precio, $descuento; // Precio y Descuento del paquete

    protected $listeners = ['editarRegistro'];

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->pago = $this->obtenerPago($this->registroSeleccionado['id']);
        $this->cliente = $this->obtenerCliente($this->registroSeleccionado['id_cliente']);
        $this->usuario = $this->obtenerUsuario($this->registroSeleccionado['id_administrativo']);
        $this->factura = $this->obtenerFactura($this->pago->id);
        if ($this->pago->concepto === 'Inscripción') {
            $this->paquete = $this->obtenerPaquete($this->pago->id);
            $this->duracion = $this->obtenerDuracion($this->pago->id);
            $detallePaquete = $this->obtenerPaqueteDuracion($this->paquete->id, $this->duracion->id);
            $this->precio = $detallePaquete[0]->precio;
            $this->descuento = $detallePaquete[0]->descuento;
        } else if ($this->pago->concepto === 'Alquiler') {
            $this->casillero = $this->obtenerCasillero($this->pago->id);
        }
        
    }

    public function obtenerCliente($idCliente) {
        $cliente = Cliente::findOrFail($idCliente);
        return $cliente;
    }

    public function obtenerUsuario($idUsuario) {
        $usuario = Empleado::findOrFail($idUsuario);
        return $usuario;
    }

    public function obtenerFactura($idPago) {
        $pago = $this->obtenerPago($idPago);
        $factura = $pago->factura;
        return $factura;
    }

    public function obtenerPago($idPago) {
        $pago = Pago::findOrFail($idPago);
        return $pago;
    }

    public function obtenerCasillero($idPago) {
        $pago = $this->obtenerPago($idPago);
        $alquiler = $pago->alquiler;
        $casillero = $alquiler->casillero;
        return $casillero;
    }

    public function obtenerPaquete($idPago) {
        $pago = $this->obtenerPago($idPago);
        $inscripcion = $pago->inscripcion;
        $paquete = $inscripcion->paquete;
        return $paquete;
    }

    public function obtenerDuracion($idPago) {
        $pago = $this->obtenerPago($idPago);
        $inscripcion = $pago->inscripcion;
        $duracion = $inscripcion->duracion;
        return $duracion;
    }

    public function obtenerPaqueteDuracion($idPaquete, $idDuracion) {
        $detallePaquete = Paquete_Duracion::where('id_paquete', $idPaquete)
                            ->where('id_duracion', $idDuracion)
                            ->get();
        return $detallePaquete;
    }

    public function formatoMoneda($precio) {
        $formateado = 'Bs '.number_format($precio, 2, ',', '.');
        return $formateado;
    }
    
    public function formatoPorcentaje($descuento) {
        $porcentaje = number_format($descuento * 100, 0).'%';
        return $porcentaje;
    }

    public function formatoFecha($fecha) {
        $fechaHora = $fecha;
        $fecha = Carbon::parse($fechaHora)->format('d/m/Y');
        $hora = Carbon::parse($fechaHora)->format('H:i:s A');
        return $fecha . ' - ' . $hora;
    }

    public function cancelar() {
        $this->emitTo('pago.show','cerrarVista');
    }

    public function render()
    {
        return view('livewire.pago.factura');
    }
}
