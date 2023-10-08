<?php

namespace App\Http\Livewire\Reporte;

use App\Models\Inscripcion;
use App\Models\Cliente;
use App\Models\Duracion;
use App\Models\Empleado;
use App\Models\Paquete;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class ReporteInscripcion extends Component
{
    public $id_cliente, $id_administrativo, $tipoReporte, $estado, $id_paquete, $id_duracion, $fechaDesde, $fechaHasta;
    public $administrativos, $clientes, $paquetes, $duraciones, $inscripciones;

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

        $query = Inscripcion::query();

        if ($this->id_administrativo != 0) {
            $query->where('id_administrativo', $this->id_administrativo);
        }

        if ($this->id_cliente != 0) {
            $query->where('id_cliente', $this->id_cliente);
        }

        if ($this->id_paquete != 0) {
            $query->where('id_paquete', $this->id_paquete);
        }

        if ($this->id_duracion != 0) {
            $query->where('id_duracion', $this->id_duracion);
        }

        if ($this->estado != 3) {
            $query->whereHas('detalle', function ($q) {
                $q->where('estado', $this->estado);
            });
        }

        $this->inscripciones = $query->whereBetween('fecha_inscripcion', [$fechaDesde, $fechaHasta])->get();
    }


    public function mount() {
        $this->administrativos = Empleado::where('tipo_empleado', 'A')
                ->orderBy('nombres', 'asc')
                ->get();
        $this->clientes = Cliente::orderBy('nombres', 'asc')->get();
        $this->paquetes = Paquete::orderBy('nombre', 'asc')->get();
        $this->duraciones = Duracion::all();
        $this->id_administrativo = 0;
        $this->id_cliente = 0;
        $this->tipoReporte = 0;
        $this->estado = 3;
        $this->id_paquete = 0;
        $this->id_duracion = 0;
        $this->generarReporte();
    }

    public function generarPDF($id_administrativo, $id_cliente, $tipoReporte, $estado, $id_paquete,   $id_duracion, $fechaInicio = null, $fechaFin = null) {

        $usuario = null;
        $cliente = null;
        $paquete = null;
        $duracion = null;

        if ($tipoReporte == 0) {
            $fechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $fechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
        } else {
            $fechaDesde = Carbon::parse($fechaInicio)->format('Y-m-d').' 00:00:00';
            $fechaHasta = Carbon::parse($fechaFin)->format('Y-m-d').' 23:59:59';
        }

        $query = Inscripcion::query();

        if ($id_administrativo != 0) {
            $query->where('id_administrativo', $id_administrativo);
            $usuario = Empleado::findOrFail($id_administrativo);
        }

        if ($id_cliente != 0) {
            $query->where('id_cliente', $id_cliente);
            $cliente = Cliente::findOrFail($id_cliente);
        }

        if ($id_paquete != 0) {
            $query->where('id_paquete', $id_paquete);
            $paquete = Paquete::findOrFail($id_paquete);
        }

        if ($id_duracion != 0) {
            $query->where('id_duracion', $id_duracion);
            $duracion = Duracion::findOrFail($id_duracion);
        }

        if ($estado != 3) {
            $query->whereHas('detalle', function ($q) use ($estado) {
                $q->where('estado', $estado);
            });
        }

        $inscripciones = $query->whereBetween('fecha_inscripcion', [$fechaDesde, $fechaHasta])->get();

        $pdf = pdf::loadView('livewire.pdf.reporteInscripcion', compact('inscripciones', 'tipoReporte', 'fechaInicio', 'fechaFin', 'usuario', 'cliente', 'paquete', 'duracion', 'estado'));
        $pdf->setPaper('a4', 'landscape'); // Opcional: Configurar el tamaño y orientación del papel

        $descripcion = 'Se generó un reporte de Inscripciones';
        registrarBitacora($descripcion);

        // Descargar o mostrar el PDF
        return $pdf->stream('reporte-inscripcion.pdf');
    }

    public function render()
    {
        return view('livewire.reporte.inscripcion');
    }
}
