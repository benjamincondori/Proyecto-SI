<?php

namespace App\Http\Livewire\Duracion;

use App\Models\Duracion;
use Livewire\Component;

class Create extends Component
{
    public $id_duracion, $nombre, $dias_duracion;

    protected $rules = [
        'nombre' => 'required|max:50',
        'dias_duracion' => 'required',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('duracion.show','cerrarVista');
    }

    public function guardarDuracion() 
    {
        $this->validate();

        try {
            $duracion = new Duracion;
            $duracion->nombre = $this->nombre;
            $duracion->dias_duracion = $this->dias_duracion;

            $duracion->save();

            $descripcion = 'Se creó una nueva duración con ID: '.$duracion->id;
            registrarBitacora($descripcion);

            $this->emitTo('duracion.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.duracion.create');
    }
}
