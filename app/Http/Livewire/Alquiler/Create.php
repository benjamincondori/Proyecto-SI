<?php

namespace App\Http\Livewire\Alquiler;

use App\Models\Alquiler;
use App\Models\Casillero;
use App\Models\Cliente;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $fecha_alquiler, $fecha_inicio, $estado, $fecha_fin, $id_cliente, $id_administrativo, $id_pago, $dias_duracion;
    public $search, $casilleros, $id_casillero;
    public $searchResults = [];
    public $selectedGrupos = [];

    protected $rules = [
        'fecha_inicio' => 'required',
        'dias_duracion' => 'required',
        'id_cliente' => 'required|exists:CLIENTE,id',
        'id_casillero' => 'required'
    ];

    protected $validationAttributes = [
        'id_cliente' => 'cliente',
        'id_casillero' => 'casillero',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    private function obtenerIdCliente($cadena) {
        $partes = explode('-', $cadena);
        $id = trim($partes[0]);
        return $id;
    }

    private function obtenerIdAdmin() {
        $user = Auth::user();
        return $user->empleado->id;
    }

    private function obtenerFechaActual() {
        date_default_timezone_set('America/La_Paz');
        $fechaHoraActual = new DateTime();
        $fechaHoraActualString = $fechaHoraActual->format('Y-m-d H:i:s');
        return $fechaHoraActualString;
    }

    public function obtenerFechaFin($fechaInicial, $diasDuracion) {
        $fechaInicialCarbon = Carbon::parse($fechaInicial);
        $fechaFinalCarbon = $fechaInicialCarbon->addDays($diasDuracion);
        $fechaFin = $fechaFinalCarbon->format('Y-m-d');
        return $fechaFin;
    }

    public function updatedSearch()
    {
        if (!empty($this->search)) {
            $this->searchResults = Cliente::where(function ($query) {
                $query->where('nombres', 'like', '%'.$this->search.'%')
                    ->orWhere('apellidos', 'like', '%'.$this->search.'%');
            })->get();

            $this->id_cliente = $this->obtenerIdCliente($this->search);
            $this->validate([
                'id_cliente' => 'required|exists:CLIENTE,id',
            ]);
        } else {
            $this->searchResults = [];
            $this->id_cliente = null;
        }
    }

    public function mount() {
        $this->casilleros = Casillero::where('estado', '1')->get();
        $this->id_administrativo = $this->obtenerIdAdmin();
    }

    public function cancelar()
    {
        $this->emitTo('alquiler.show', 'cerrarVista');
    }

    public function guardarAlquiler() {

        $this->validate();

        try {
            $alquiler = new Alquiler();

            $alquiler->dias_duracion = $this->dias_duracion;
            $alquiler->fecha_inicio = $this->fecha_inicio;
            $alquiler->fecha_fin = $this->obtenerFechaFin($this->fecha_inicio, $this->dias_duracion);
            $alquiler->id_casillero = $this->id_casillero;
            $alquiler->id_cliente = $this->id_cliente;
            $alquiler->id_administrativo = $this->id_administrativo;
            $alquiler->fecha_alquiler = $this->obtenerFechaActual();

            $guardado = $alquiler->save();

            if ($guardado) {
                $casillero = Casillero::findOrFail($alquiler->id_casillero);
                $casillero->estado = 0;
                $casillero->save();

                $descripcion = 'Se creó un nuevo alquiler con ID: '.$alquiler->id;
                registrarBitacora($descripcion);
    
                $this->emitTo('alquiler.show', 'cerrarVista');
                $this->emit('alert', 'guardado');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.alquiler.create');
    }
}
