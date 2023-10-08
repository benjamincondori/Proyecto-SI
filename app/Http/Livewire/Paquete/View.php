<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;

class View extends Component
{
    public $id_paquete, $nombre, $descripcion;
    public $disciplinas = [];
    public $duraciones = [];

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $paquete = Paquete::find($registroSeleccionado['id']);
        $this->disciplinas = $paquete->disciplinas;
        $this->duraciones = $paquete->duraciones;
        $this->id_paquete = $paquete->id;
        $this->nombre = $paquete->nombre;
        $this->descripcion = $paquete->descripcion;
    }

    public function cancelar()
    {
        $this->emit('cerrarVista');
    }

    public function render()
    {
        return view('livewire.paquete.view');
    }
}
