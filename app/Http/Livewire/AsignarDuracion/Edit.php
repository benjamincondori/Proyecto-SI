<?php

namespace App\Http\Livewire\AsignarDuracion;

use App\Models\Duracion;
use App\Models\Paquete;
use Livewire\Component;

class Edit extends Component
{
    public  $registroSeleccionado, $id_paquete, $id_duracion, $descuento;
    public $paquetes, $duraciones;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'id_paquete' => 'required',
        'id_duracion' => 'required',
        'registroSeleccionado.precio' => 'required',
        'descuento' => 'required',
    ];

    protected $validationAttributes = [
        'id_paquete' => 'paquete',
        'id_duracion' => 'duracion',
        'registroSeleccionado.precio' => 'precio',
        'descuento' => 'descuento'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $this->id_paquete = $this->registroSeleccionado['id_paquete'];
        $this->id_duracion = $this->registroSeleccionado['id_duracion'];
        $this->descuento = $this->formatoPorcentaje($this->registroSeleccionado['descuento']);
    }

    public function formatoPorcentaje($descuento) {
        $porcentaje = number_format($descuento * 100, 0);
        return $porcentaje;
    }

    public function formatoDecimal($descuento) {
        $porcentaje = number_format($descuento / 100, 2);
        return $porcentaje;
    }

    public function cancelar()
    {
        $this->emitTo('asignar-duracion.show','cerrarVista');
    }

    public function calcularPrecio($paqueteId, $duracionId) {
        if ($paqueteId && $duracionId) {
            $paquete = Paquete::findOrFail($paqueteId);
            $duracion = Duracion::findOrFail($duracionId);
            $disciplinas = $paquete->disciplinas;
            $precioPaquete = 0;

            foreach ($disciplinas as $disciplina) {
                $precioPorDia = $disciplina->precio / 30;
                $precioPaquete += $precioPorDia * $duracion->dias_duracion;
            }

            return $precioPaquete;
        }
        return 0;
    }

    public function updatedIdPaquete() {
        $this->registroSeleccionado['precio'] = $this->calcularPrecio($this->id_paquete, $this->id_duracion);
    }

    public function updatedIdDuracion() {
        $this->registroSeleccionado['precio'] = $this->calcularPrecio($this->id_paquete, $this->id_duracion);
    }

    public function actualizarAsignacion() 
    {
        $this->validate();
    
        try {
            $paqueteAnterior = Paquete::findOrFail($this->registroSeleccionado['id_paquete']);
            $paquete = Paquete::findOrFail($this->id_paquete);

            if ($paquete) {
                $paqueteAnterior->duraciones()->detach($this->registroSeleccionado['id_duracion']);
                $paquete->duraciones()->attach($this->id_duracion, [
                    'precio' => $this->registroSeleccionado['precio'],
                    'descuento' => $this->formatoDecimal($this->descuento),
                ]);

                $descripcion = 'Se actualizó la duración asignada con ID: '.$this->id_duracion.' al paquete '.$paquete->nombre;
                registrarBitacora($descripcion);

                $this->emitTo('asignar-duracion.show', 'cerrarVista');
                $this->emit('alert', 'guardado');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function mount() {
        $this->paquetes = Paquete::all();
        $this->duraciones = Duracion::all();
    }

    public function render()
    {
        return view('livewire.asignar-duracion.edit');
    }
}
