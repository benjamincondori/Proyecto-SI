<?php

namespace App\Http\Livewire\Pago;

use App\Models\Pago;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Visita extends Component
{
    public $id_pago, $concepto, $fecha, $monto, $estado, $id_administrativo;
    public $efectivo, $cambio;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'monto' => 'required',
        'efectivo' => 'required',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro($registroSeleccionado)
    {
        if (isset($registroSeleccionado)) {
            $this->monto = $registroSeleccionado['monto'];
            $this->estado = $registroSeleccionado['estado'];
            $this->id_pago = $registroSeleccionado['id'];
            $this->efectivo = $registroSeleccionado['efectivo'];
            $this->cambio = $registroSeleccionado['cambio'];
        }
    }

    public function actualizarCambio() {
        if (isset($this->monto) && !empty($this->monto) 
            && isset($this->efectivo) && !empty($this->efectivo)) {
            $this->cambio = $this->efectivo - $this->monto;
        } else {
            $this->cambio = '';
        }
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

    public function cancelar() {
        $this->emitTo('pago.show','cerrarVista');
    }

    public function mount() {
        $this->concepto = 'Visita';
        $this->id_administrativo = $this->obtenerIdAdmin();
        // $this->estado = false;
    }

    public function guardarPago() 
    {
        $this->validate();

        try {
            $pago = new Pago();
            $pago->id_administrativo = $this->id_administrativo;
            $pago->monto = $this->monto;
            $pago->efectivo = $this->efectivo;
            $pago->cambio = $this->cambio;
            $pago->concepto = $this->concepto;
            $pago->estado = true;
            $pago->fecha = $this->obtenerFechaActual();

            $pago->save();

            $descripcion = 'Se registró un nuevo pago con ID: '.$pago->id;
            registrarBitacora($descripcion);

            $this->emitTo('pago.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.pago.visita');
    }
}
