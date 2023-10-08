<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportarController extends Controller
{

    // public function reporte() {
    //     return view('livewire.pdf.reporteInscripcion');
    // }

    // public function reporteInscripcionPDF($id_administrativo, $id_cliente, $tipoReporte, $estado = '', $id_paquete, $id_duracion, $fechaDesde = null, $fechaHasta = null) {

    //     $inscripciones = [];

    //     if ($tipoReporte == 0) {
    //         $fechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
    //         $fechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
    //     } else {
    //         $fechaDesde = Carbon::parse($fechaDesde)->format('Y-m-d').' 00:00:00';
    //         $fechaHasta = Carbon::parse($fechaHasta)->format('Y-m-d').' 23:59:59';
    //     }

    //     $query = Inscripcion::query();

    //     if ($id_administrativo != 0) {
    //         $query->where('id_administrativo', $id_administrativo);
    //     }

    //     if ($id_cliente != 0) {
    //         $query->where('id_cliente', $id_cliente);
    //     }

    //     if ($id_paquete != 0) {
    //         $query->where('id_paquete', $id_paquete);
    //     }

    //     if ($id_duracion != 0) {
    //         $query->where('id_duracion', $id_duracion);
    //     }

    //     if ($estado != '') {
    //         $query->whereHas('detalle', function ($q) use ($estado) {
    //             $q->where('estado', $estado);
    //         });
    //     }

    //     $inscripciones = $query->whereBetween('fecha_inscripcion', [$fechaDesde, $fechaHasta])->get();

    //     // dd($inscripciones);

    //     dd(compact('inscripciones', 'tipoReporte', 'id_administrativo', 'id_cliente', 'id_paquete', 'id_duracion', 'estado', 'fechaDesde', 'fechaHasta'));

    //     $pdf = Pdf::loadView('pdf.reporteInscripcion', compact('inscripciones', 'tipoReporte', 'id_administrativo', 'id_cliente', 'id_paquete', 'id_duracion', 'estado', 'fechaDesde', 'fechaHasta'));
    //     return $pdf->stream('reporteInscripcion.pdf');

    // }
}
