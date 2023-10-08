<?php

namespace App\Http\Livewire\Reporte;

use App\Models\Alquiler;
use App\Models\Casillero;
use App\Models\Cliente;
use App\Models\Empleado;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class ReporteAlquiler extends Component
{
    public $id_cliente, $id_administrativo, $tipoReporte, $estado, $id_casillero, $fechaDesde, $fechaHasta;
    public $administrativos, $clientes, $casilleros, $alquileres;

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

        $query = Alquiler::query();

        if ($this->id_administrativo != 0) {
            $query->where('id_administrativo', $this->id_administrativo);
        }

        if ($this->id_cliente != 0) {
            $query->where('id_cliente', $this->id_cliente);
        }

        if ($this->id_casillero != 0) {
            $query->where('id_casillero', $this->id_casillero);
        }

        if ($this->estado != 3) {
            $query->where('estado', $this->estado);
        }

        $this->alquileres = $query->whereBetween('fecha_alquiler', [$fechaDesde, $fechaHasta])->get();
    }

    public function mount() {
        $this->administrativos = Empleado::where('tipo_empleado', 'A')
                ->orderBy('nombres', 'asc')
                ->get();
        $this->clientes = Cliente::orderBy('nombres', 'asc')->get();
        $this->casilleros = Casillero::all();
        $this->id_administrativo = 0;
        $this->id_cliente = 0;
        $this->tipoReporte = 0;
        $this->estado = 3;
        $this->id_casillero = 0;
        $this->generarReporte();
    }

    public function generarPDF($id_administrativo, $id_cliente, $tipoReporte, $estado, $id_casillero, $fechaInicio = null, $fechaFin = null) {

        $usuario = null;
        $cliente = null;
        $casillero = null;

        if ($tipoReporte == 0) {
            $fechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $fechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
        } else {
            $fechaDesde = Carbon::parse($fechaInicio)->format('Y-m-d').' 00:00:00';
            $fechaHasta = Carbon::parse($fechaFin)->format('Y-m-d').' 23:59:59';
        }

        $query = Alquiler::query();

        if ($id_administrativo != 0) {
            $query->where('id_administrativo', $id_administrativo);
            $usuario = Empleado::findOrFail($id_administrativo);
        }

        if ($id_cliente != 0) {
            $query->where('id_cliente', $id_cliente);
            $cliente = Cliente::findOrFail($id_cliente);
        }

        if ($id_casillero != 0) {
            $query->where('id_casillero', $id_casillero);
            $paquete = Casillero::findOrFail($id_casillero);
        }

        if ($estado != 3) {
            $query->where('estado', $estado);
        }

        $alquileres = $query->whereBetween('fecha_alquiler', [$fechaDesde, $fechaHasta])->get();

        $pdf = pdf::loadView('livewire.pdf.reporteAlquiler', compact('alquileres', 'tipoReporte', 'fechaInicio', 'fechaFin', 'usuario', 'cliente', 'casillero',  'estado'));
        $pdf->setPaper('a4', 'landscape'); // Opcional: Configurar el tamaño y orientación del papel

        $descripcion = 'Se generó un reporte de Alquileres';
        registrarBitacora($descripcion);

        // Descargar o mostrar el PDF
        return $pdf->stream('reporte-alquiler.pdf');
    }

    public function render()
    {
        return view('livewire.reporte.reporte-alquiler');
    }
}
