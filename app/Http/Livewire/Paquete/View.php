<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;

class View extends Component
{
    public $registroSeleccionado;
    public $id_paquete, $nombre, $descripcion;
    public $disciplinas = [];

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;

        $paquete = Paquete::find($this->registroSeleccionado['id']);
        $this->disciplinas = $paquete->disciplinas;
        $this->id_paquete = $this->registroSeleccionado['id'];
        $this->nombre = $this->registroSeleccionado['nombre'];
        $this->descripcion = $this->registroSeleccionado['descripcion'];
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
