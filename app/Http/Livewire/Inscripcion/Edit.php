<?php

namespace App\Http\Livewire\Inscripcion;

use App\Models\Cliente;
use App\Models\Duracion;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Paquete;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado, $id_cliente;
    public $paquetes, $duraciones, $grupos, $idPaquete;
    public $search;
    public $searchResults = [];
    public $selectedGrupos = [];
    public $seleccionados = [];
    public $seleccionarNuevo = false;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.fecha_inicio' => 'required',
        'id_cliente' => 'required|exists:cliente,id',
        'idPaquete' => 'required',
        'registroSeleccionado.id_duracion' => 'required'
    ];

    protected $validationAttributes = [
        'id_cliente' => 'cliente',
        'idPaquete' => 'paquete',
        'registroSeleccionado.id_duracion' => 'duracion',
        'selectedGrupos' => 'grupo'
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

    // public function obtenerGrupos($id_inscripcion) {
    //     return Grupo::join('disciplina', 'grupo.id_disciplina', '=', 'disciplina.id')
    //     ->join('disciplina_paquete', 'disciplina.id', '=', 'disciplina_paquete.id_disciplina')
    //     ->join('paquete', 'disciplina_paquete.id_paquete', '=', 'paquete.id')
    //     ->join('inscripcion', 'paquete.id', '=', 'inscripcion.id_paquete')
    //     ->where('inscripcion.id', $id_inscripcion)
    //     ->select('grupo.*')
    //     ->get();
    // }

    public function obtenerGrupos($paqueteId)
    {
        return Grupo::join('disciplina', 'grupo.id_disciplina', '=', 'disciplina.id')
            ->join('disciplina_paquete', 'disciplina.id', '=', 'disciplina_paquete.id_disciplina')
            ->join('paquete', 'disciplina_paquete.id_paquete', '=', 'paquete.id')
            ->where('paquete.id', $paqueteId)
            ->select('grupo.*')
            ->get();
    }

    public function formatoHora($hora)
    {
        return Carbon::createFromFormat('H:i:s', $hora)->format('H:i A');
    }

    public function updatedIdPaquete() {
        $this->grupos = $this->obtenerGrupos($this->idPaquete);
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
                'id_cliente' => 'required|exists:cliente,id',
            ]);
        } else {
            $this->searchResults = [];
            $this->id_cliente = null;
        }
    }

    public function editarRegistro(Inscripcion $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->id_cliente = $this->registroSeleccionado->id_cliente;
        $this->search = $this->obtenerNombreCliente($this->id_cliente);

        $inscripcion = Inscripcion::find($this->registroSeleccionado['id']);
        $this->seleccionados = $inscripcion->grupos;

        $this->idPaquete = $this->registroSeleccionado->id_paquete;
        $this->grupos = $this->obtenerGrupos($this->idPaquete);
    }

    public function mount() {
        $this->paquetes = Paquete::all();
        $this->duraciones = Duracion::pluck('nombre', 'id')->toArray();
    }

    public function cancelar()
    {
        $this->emitTo('inscripcion.show','cerrarVista');
    }

    public function actualizarInscripcion() 
    {
        $this->validate([
            'registroSeleccionado.fecha_inicio' => 'required',
            'id_cliente' => 'required|exists:cliente,id',
            'idPaquete' => 'required',
            'registroSeleccionado.id_duracion' => 'required',
            'selectedGrupos' => $this->seleccionarNuevo ? 'required' : ''
        ]);
        
        // dd($this->id_cliente, $this->registroSeleccionado->fecha_inicio, $this->idPaquete, $this->registroSeleccionado->id_duracion, $this->obtenerFechaActual(), $this->selectedGrupos);
    
        // Realizar la actualización del registro seleccionado
        $inscripcion = Inscripcion::find($this->registroSeleccionado['id']);

        $inscripcion->fecha_inicio = $this->registroSeleccionado['fecha_inicio'];
        $inscripcion->id_paquete = $this->idPaquete;
        $inscripcion->id_duracion = $this->registroSeleccionado['id_duracion'];
        $inscripcion->id_cliente = $this->id_cliente;
        // $inscripcion->id_administrativo = $this->id_administrativo;
        $inscripcion->fecha_inscripcion = $this->obtenerFechaActual();

        try {
            $inscripcion->save();

            if($this->seleccionarNuevo) {
                $inscripcion->grupos()->sync($this->selectedGrupos);
            } 

            $this->emitTo('inscripcion.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.inscripcion.edit');
    }
}
