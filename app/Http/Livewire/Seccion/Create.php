<?php

namespace App\Http\Livewire\Seccion;

use App\Models\Seccion;
use Livewire\Component;

class Create extends Component
{
    public $id_seccion, $nombre, $descripcion, $capacidad;

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:150',
        'capacidad' => 'required'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('seccion.show', 'cerrarVista');
    }

    public function guardarSeccion() 
    {
        $this->validate();

        try {
            $seccion = new Seccion;

            $seccion->nombre = $this->nombre;
            $seccion->descripcion = $this->descripcion;
            $seccion->capacidad = $this->capacidad;

            $seccion->save();

            $descripcion = 'Se creó una nueva sección con ID: '.$seccion->id;
            registrarBitacora($descripcion);

            $this->emitTo('seccion.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function render()
    {
        return view('livewire.seccion.create');
    }
}
