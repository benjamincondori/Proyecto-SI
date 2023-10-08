<?php

namespace App\Http\Livewire\Pago;

use App\Models\Pago;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado, $verificarPermiso;
    public $vistaVisita = false;
    public $vistaFactura = false;
    public $vistaCrear = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarPago' => 'eliminarPago'
    ];

    public function seleccionarPago($registroId, $vista)
    {
        $this->registroSeleccionado = Pago::findOrFail($registroId);

        if ($vista === 'pagar') {
            if (verificarPermiso('Pago_Create')) {
                $this->vistaCrear = true;
                $this->emit('editarRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        } elseif ($vista ==='factura') {
            if (verificarPermiso('Pago_Factura')) {
                $this->vistaFactura = true;
                $this->emit('editarRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        } else {
            if (verificarPermiso('Pago_Visita')) {
                $this->vistaVisita = true;
                $this->emit('editarRegistro', $this->registroSeleccionado);
            } else {
                $this->emit('accesoDenegado');
            }
        }
    }

    public function obtenerFechaPago($registroId) {
        $fecha_pago = Pago::find($registroId);
        $fecha = Carbon::parse($fecha_pago->fecha)->format('d/m/Y');
        $hora = Carbon::parse($fecha_pago->fecha)->format('H:i:s A');
        return $fecha . ' - ' . $hora;
    }

    public function formatoMoneda($precio) {
        $formateado = number_format($precio, 2, ',', '.').' Bs';
        return $formateado;
    }


    public function agregarNuevo()
    {
        if (verificarPermiso('Pago_Visita')) {
            $this->vistaVisita = true;
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function cerrarVista()
    {
        $this->vistaCrear = false;
        $this->vistaFactura = false;
        $this->vistaVisita = false;
    }

    public function order($sort) 
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function updatedCant()
    {
        $this->resetPage();
        $this->gotoPage(1);
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pagos = Pago::where('id', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.pago.show', ['pagos' => $pagos]);
    }
}
