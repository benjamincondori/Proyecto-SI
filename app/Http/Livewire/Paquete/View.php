<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;

class View extends Component
{
    public $registroSeleccionado;
    public $paquetes;

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
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
