<?php

namespace App\Http\Livewire\AsignarDuracion;

use App\Models\Duracion;
use App\Models\Paquete;
use Livewire\Component;

class Create extends Component
{
    public $id_paquete, $id_duracion, $precio, $descuento;
    public $paquetes, $duraciones;

    protected $rules = [
        'id_paquete' => 'required',
        'id_duracion' => 'required',
        'precio' => 'required',
        'descuento' => 'required',
    ];

    protected $validationAttributes = [
        'id_paquete' => 'paquete',
        'id_duracion' => 'duracion'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('asignar-duracion.show', 'cerrarVista');
    }

    public function formatoPorcentaje($descuento) {
        $porcentaje = number_format($descuento / 100, 2);
        return $porcentaje;
    }

    public function guardarAsignacion() 
    {
        $this->validate();

        try {

            $paquete = Paquete::findOrFail($this->id_paquete);

            if ($paquete) {
                $paquete->duraciones()->attach($this->id_duracion, [
                    'precio' => $this->precio,
                    'descuento' => $this->formatoPorcentaje($this->descuento),
                ]);

                $descripcion = 'Se asignó una nueva duración con ID: '.$this->id_duracion.' al paquete '.$paquete->nombre;
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
        return view('livewire.asignar-duracion.create');
    }
}
