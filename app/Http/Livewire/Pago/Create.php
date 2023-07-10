<?php

namespace App\Http\Livewire\Pago;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Inscripcion;
use App\Models\Pago;
use App\Models\Paquete_Duracion;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $id_pago, $concepto, $fecha, $monto, $estado, $id_administrativo, $id_cliente;
    public $registroSeleccionado, $nombre, $descripcion, $efectivo, $cambio, $nit;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        // 'id_cliente' => 'required|exists:CLIENTE,id',
        // 'descripcion' => 'required|max:255',
        'efectivo' => 'required',
    ];

    protected $validationAttributes = [
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->estado = $this->registroSeleccionado['estado'];
        $this->id_pago = $this->registroSeleccionado['id'];
        $this->id_cliente = $this->registroSeleccionado['id_cliente'];
        $this->efectivo = $this->registroSeleccionado['efectivo'];
        $this->cambio = $this->registroSeleccionado['cambio'];
        $this->nombre = $this->obtenerNombreCliente($this->id_cliente);
        $this->monto = $this->formatoMoneda($this->registroSeleccionado['monto']);
        if ($this->registroSeleccionado['concepto'] == 'Inscripción') {
            $this->descripcion = $this->obtenerDescripcion($this->id_pago);
        } else if ($this->registroSeleccionado['concepto'] == 'Alquiler') {

        }
    }

    public function obtenerNombreCliente($clienteId) {
        $cliente = Cliente::findOrFail($clienteId);
        $nombre = $cliente->nombres.' '.$cliente->apellidos;
        return $nombre;
    }

    public function obtenerDescripcion($idPago) {
        $pago = Pago::findOrFail($idPago);
        $paquete = $pago->inscripcion->paquete;
        $duracion = $pago->inscripcion->duracion;
        $disciplinas = $pago->inscripcion->paquete->disciplinas ;

        $informacionDisciplinas = '';
        foreach ($disciplinas as $disciplina) {
            $nombre = $disciplina->nombre;
            $precio = $disciplina->precio;
            $informacionDisciplinas .= "  - $nombre ($precio Bs)\n";
        }

        $detallePaquete = Paquete_Duracion::where('id_paquete', $pago->inscripcion->id_paquete)
                                    ->where('id_duracion', $pago->inscripcion->id_duracion)
                                    ->get();

        $precioPaquete = $detallePaquete[0]->precio;
        $descuento = $this->formatoPorcentaje($detallePaquete[0]->descuento);
        $montoTotal = $pago->monto;

        $descripcion = "Paquete: $paquete->nombre \nDuración: $duracion->nombre ($duracion->dias_duracion días) \nDisciplinas: \n$informacionDisciplinas";
        $descripcion .= "Precio Paquete: $precioPaquete Bs \nDescuento: $descuento \nMonto total a pagar: $montoTotal Bs";
        return $descripcion;
    }

    public function formatoPorcentaje($descuento) {
        $porcentaje = number_format($descuento * 100, 0).'%';
        return $porcentaje;
    }

    public function formatoMoneda($precio) {
        $formateado = number_format($precio, 0, ',', '.');
        return $formateado;
    }

    public function quitarFormatoMoneda($precio) {
        $sinPuntos = str_replace('.', '', $precio);
        return $sinPuntos;
    }

    public function actualizarCambio() {
        $efectivo = $this->quitarFormatoMoneda($this->efectivo);
        if ($efectivo) {
            $monto = $this->registroSeleccionado['monto'];
            $cambio = $efectivo - $monto;
            $this->efectivo = $this->formatoMoneda($efectivo);
            $this->cambio = $this->formatoMoneda($cambio);
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

    public function obtenerMonto($idPago) {
        $pago = Pago::findOrFail($idPago);
        return $pago->monto;
    }

    public function cancelar() {
        $this->emitTo('pago.show','cerrarVista');
    }

    public function mount() {
        $this->id_administrativo = $this->obtenerIdAdmin();
    }

    public function guardarPago() 
    {
        $this->validate();

        try {
            $pago = Pago::findOrFail($this->id_pago);
            $pago->id_administrativo = $this->id_administrativo;
            $pago->efectivo = $this->quitarFormatoMoneda($this->efectivo);
            $pago->cambio = $this->quitarFormatoMoneda($this->cambio);
            $pago->estado = true;
            $pago->fecha = $this->obtenerFechaActual();

            $guardado = $pago->save();

            $descripcion = 'Se registró un nuevo pago con ID: '.$pago->id;
            registrarBitacora($descripcion);

            if ($guardado) {
                $inscripcion = $pago->inscripcion->detalle;
                $inscripcion->estado = true;
                $inscripcion->save();

                $factura = new Factura();
                $factura->descripcion = $this->descripcion;
                $factura->monto_total = $pago->monto;
                $factura->NIT = $this->nit;
                $factura->id_pago = $pago->id;
                $factura->fecha_emision = $this->obtenerFechaActual();

                $factura->save();

                $this->emitTo('pago.show', 'cerrarVista');
                $this->emit('alert', 'guardado');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.pago.create');
    }
}
