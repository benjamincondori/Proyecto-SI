<?php

namespace App\Http\Livewire\TipoMaquina;

use Livewire\Component;
use App\Models\Tipo_Maquina;

class Create extends Component
{
    public $id_maquina, $nombre, $descripcion;

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:150'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('tipo-maquina.show', 'cerrarVista');
    }

    public function guardarMaquina() 
    {
        $this->validate();

        try {
            $maquina = new Tipo_Maquina;

            $maquina->nombre = $this->nombre;
            $maquina->descripcion = $this->descripcion;

            $maquina->save();
            $this->emitTo('tipo-maquina.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function render()
    {
        return view('livewire.tipo-maquina.create');
    }
}
