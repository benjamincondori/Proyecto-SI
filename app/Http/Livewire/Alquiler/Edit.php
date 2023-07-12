<?php

namespace App\Http\Livewire\Alquiler;

use App\Models\Alquiler;
use App\Models\Casillero;
use App\Models\Cliente;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado, $id_cliente;
    public $search, $casilleros, $id_casillero;
    public $searchResults = [];

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.fecha_inicio' => 'required',
        'registroSeleccionado.dias_duracion' => 'required',
        'id_cliente' => 'required|exists:CLIENTE,id',
        'registroSeleccionado.id_casillero' => 'required'
    ];

    protected $validationAttributes = [
        'id_cliente' => 'cliente',
        'registroSeleccionado.id_casillero' => 'casillero',
    ];

    public function updated($propertyName)
    {
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

    private function obtenerNombreCliente($id) {
        $cliente = Cliente::findOrFail($id);
        $nombre = $id.' - '.$cliente->nombres.' '.$cliente->apellidos;
        return $nombre;
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

    public function editarRegistro(Alquiler $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->id_cliente = $this->registroSeleccionado->id_cliente;
        $this->search = $this->obtenerNombreCliente($this->id_cliente);

        $inscripcion = Alquiler::find($this->registroSeleccionado['id']);
    }

    public function mount() {
        $this->casilleros = Casillero::where('estado', '1')->get();
        $this->registroSeleccionado['id_administrativo'] = $this->obtenerIdAdmin();
    }

    public function cancelar()
    {
        $this->emitTo('alquiler.show','cerrarVista');
    }

    public function actualizarAlquiler() 
    {
        $this->validate();
        
        try {
            // Realizar la actualización del registro seleccionado
            $alquiler = Alquiler::find($this->registroSeleccionado['id']);

            $alquiler->dias_duracion = $this->registroSeleccionado['dias_duracion'];
            $alquiler->fecha_inicio = $this->registroSeleccionado['fecha_inicio'];
            $alquiler->fecha_fin = $this->obtenerFechaFin($this->registroSeleccionado['fecha_inicio'], $this->registroSeleccionado['dias_duracion']);
            $alquiler->id_casillero = $this->registroSeleccionado['id_casillero'];
            $alquiler->id_cliente = $this->id_cliente;
            $alquiler->id_administrativo = $this->registroSeleccionado['id_administrativo'];
            $alquiler->fecha_alquiler = $this->obtenerFechaActual();

            $alquiler->save();

            $descripcion = 'Se actualizó el alquiler con ID: '.$alquiler->id;
            registrarBitacora($descripcion);

            $this->emitTo('alquiler.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.alquiler.edit');
    }
}
