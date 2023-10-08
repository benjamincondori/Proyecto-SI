<?php

namespace App\Http\Livewire\Reporte;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Factura;
use App\Models\Pago;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteFactura extends Component
{
    public $id_cliente, $id_administrativo, $tipoReporte, $fechaDesde, $fechaHasta;
    public $administrativos, $clientes, $facturas;

    protected $rules = [ 
        'fechaDesde' => 'required',
        'fechaHasta' => 'required'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function updatedTipoReporte() {
        if ($this->tipoReporte == 0) {
            $this->fechaDesde = null;
            $this->fechaHasta = null;
        }
    }

    public function generarReporte() {
        $this->validate([
            'fechaDesde' => ($this->tipoReporte == 1) ? 'required' : '',
            'fechaHasta' => ($this->tipoReporte == 1) ? 'required' : '',
        ]);

        if ($this->tipoReporte == 0) {
            $fechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $fechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
        } else {
            $fechaDesde = Carbon::parse($this->fechaDesde)->format('Y-m-d').' 00:00:00';
            $fechaHasta = Carbon::parse($this->fechaHasta)->format('Y-m-d').' 23:59:59';
        }

        $query = Pago::has('factura');

        if ($this->id_administrativo != 0) {
            $query->where('id_administrativo', $this->id_administrativo);
        }

        if ($this->id_cliente != 0) {
            $query->where('id_cliente', $this->id_cliente);
        }

        $this->facturas = $query->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get();
    }


    public function mount() {
        $this->administrativos = Empleado::where('tipo_empleado', 'A')
                ->orderBy('nombres', 'asc')
                ->get();
        $this->clientes = Cliente::orderBy('nombres', 'asc')->get();
        $this->id_administrativo = 0;
        $this->id_cliente = 0;
        $this->tipoReporte = 0;
        $this->generarReporte();
    }

    // public function generarPDF($id_administrativo, $id_cliente, $tipoReporte, $estado, $concepto, $fechaInicio = null, $fechaFin = null) {

    //     $usuario = null;
    //     $cliente = null;

    //     if ($tipoReporte == 0) {
    //         $fechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
    //         $fechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
    //     } else {
    //         $fechaDesde = Carbon::parse($fechaInicio)->format('Y-m-d').' 00:00:00';
    //         $fechaHasta = Carbon::parse($fechaFin)->format('Y-m-d').' 23:59:59';
    //     }

    //     $query = Factura::query();

    //     if ($id_administrativo != 0) {
    //         $query->where('id_administrativo', $id_administrativo);
    //         $usuario = Empleado::findOrFail($id_administrativo);
    //     }

    //     if ($id_cliente != 0) {
    //         $query->where('id_cliente', $id_cliente);
    //         $cliente = Cliente::findOrFail($id_cliente);
    //     }

    //     if ($concepto != 0) {
    //         $query->where('concepto', $concepto);
    //     }

    //     if ($estado != 3) {
    //         $query->where('estado', $estado);
    //     }

    //     $pagos = $query->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get();
    //     // $totalMontos = $pagos->pluck('monto')->sum();
    //     $totalMontos = $pagos->sum(function($item) {
    //         return $item->monto;
    //     });

    //     $pdf = pdf::loadView('livewire.pdf.reportePago', compact('pagos', 'tipoReporte', 'fechaInicio', 'fechaFin', 'usuario', 'cliente', 'concepto', 'estado', 'totalMontos'));
    //     $pdf->setPaper('a4', 'landscape'); // Opcional: Configurar el tamaño y orientación del papel

    //     // Descargar o mostrar el PDF
    //     return $pdf->stream('reporte-pago.pdf');
    // }

    public function render()
    {
        return view('livewire.reporte.reporte-factura');
    }
}
