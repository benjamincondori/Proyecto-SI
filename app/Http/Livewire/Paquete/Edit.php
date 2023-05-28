<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;
    // public $secciones;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:50',
        'registroSeleccionado.descripcion' => 'required|max:100'
    ];

    // public function mount() {
    //     $this->secciones = Seccion::pluck('nombre', 'id')->toArray();
    // }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('paquete.show','cerrarVista');
    }

    public function actualizarPaquete() 
    {
        $this->validate();
    
        // Realiza la actualización del registro seleccionado
        $registro = Paquete::find($this->registroSeleccionado['id']);
        $registro->nombre = $this->registroSeleccionado['nombre'];
        $registro->descripcion = $this->registroSeleccionado['descripcion'];
        $registro->save();
    
        $this->emitTo('paquete.show', 'cerrarVista');
        $this->emit('alert', 'actualizado');

    }

    public function render()
    {
        return view('livewire.paquete.edit');
    }
}
