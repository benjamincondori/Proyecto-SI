<?php

namespace App\Http\Livewire\Disciplina;

use App\Models\Disciplina;
use App\Models\Seccion;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;
    public $secciones;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:50',
        'registroSeleccionado.descripcion' => 'required|max:150',
        'registroSeleccionado.precio' => 'required',
        'registroSeleccionado.id_seccion' => 'required'
    ];

    protected $validationAttributes = [
        'registroSeleccionado.id_seccion' => 'seccion'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount() {
        $this->secciones = Seccion::pluck('nombre', 'id')->toArray();
    }

    public function editarRegistro(Disciplina $registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('disciplina.show','cerrarVista');
    }

    public function actualizarDisciplina() 
    {
        $this->validate();
    
        try {
            // Realizar la actualización del registro seleccionado
            $registro = Disciplina::find($this->registroSeleccionado['id']);
            $registro->nombre = $this->registroSeleccionado['nombre'];
            $registro->descripcion = $this->registroSeleccionado['descripcion'];
            $registro->precio = $this->registroSeleccionado['precio'];
            $registro->id_seccion = $this->registroSeleccionado['id_seccion'];
        
            $registro->save();
            
            $this->emitTo('disciplina.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $this->emit('error');
        }

    }

    public function render()
    {
        return view('livewire.disciplina.edit');
    }
}
