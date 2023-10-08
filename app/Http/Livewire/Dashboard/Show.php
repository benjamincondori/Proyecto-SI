<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Inscripcion;
use App\Models\Pago;
use Livewire\Component;

class Show extends Component
{
    public $clientes, $entrenadores, $inscripciones, $ingresos;

    public function mount() {
        $this->clientes = Cliente::count();
        $this->entrenadores = Empleado::where('tipo_empleado', 'E')->count();
        $this->inscripciones = Inscripcion::count();
        $this->ingresos = Pago::sum('monto');
    }

    public function formatoMoneda($precio) {
        $formateado = number_format($precio, 0, ',', '.');
        return $formateado;
    }

    public function render()
    {
        return view('livewire.dashboard.show');
    }
}
