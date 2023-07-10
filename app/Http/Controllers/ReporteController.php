<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Pago;
use App\Models\Paquete_Duracion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function factura($idPago) {
        if (isset($idPago) && !empty($idPago)) {
            $pago = Pago::findOrFail($idPago);
            $cliente = $this->obtenerCliente($pago->id_cliente);
            $usuario = $this->obtenerUsuario($pago->id_administrativo);
            $factura = $this->obtenerFactura($pago->id);
            $paquete = $this->obtenerPaquete($pago->id);
            $duracion = $this->obtenerDuracion($pago->id);
            $detallePaquete = $this->obtenerPaqueteDuracion($paquete->id, $duracion->id);
            $precio = $detallePaquete[0]->precio;
            $descuento = $detallePaquete[0]->descuento;
    
            $pdf = Pdf::loadView('reporte.factura', compact('pago', 'cliente', 'usuario', 'factura', 'paquete', 'duracion', 'detallePaquete', 'precio', 'descuento'));
            return $pdf->stream('factura.pdf');
        }
    }

    public function obtenerCliente($idCliente) {
        $cliente = Cliente::findOrFail($idCliente);
        return $cliente;
    }

    public function obtenerPago($idPago) {
        $pago = Pago::findOrFail($idPago);
        return $pago;
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

}
