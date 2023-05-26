<?php

namespace App\Http\Livewire\Seccion;

use App\Models\Seccion;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:50',
        'registroSeleccionado.descripcion' => 'required|max:150',
        'registroSeleccionado.capacidad' => 'required',
    ];

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emit('cancelarEdicion');
    }

    public function actualizarSeccion() 
    {
        $this->validate();
    
        // Realizar la actualización del registro seleccionado
        $registro = Seccion::find($this->registroSeleccionado['id']);
        $registro->nombre = $this->registroSeleccionado['nombre'];
        $registro->descripcion = $this->registroSeleccionado['descripcion'];
        $registro->capacidad = $this->registroSeleccionado['capacidad'];
        $registro->save();
    
        $this->emitTo('Seccion.Show','render');
        $this->emit('registroActualizado');

        // Limpiar la propiedad $registroSeleccionado
        $this->registroSeleccionado = null;

    }

    public function render()
    {
        return view('livewire.seccion.edit');
    }
}
