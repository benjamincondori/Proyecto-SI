<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Disciplina;
use App\Models\Paquete;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;
    public $selectedDisciplinas = [];
    public $disciplinas;

    protected $listeners = ['editarRegistro'];

    protected $rules = [
        'registroSeleccionado.nombre' => 'required|max:50',
        'registroSeleccionado.descripcion' => 'required|max:100'
    ];

    protected $validationAttributes = [
        'registroSeleccionado.nombre' => 'nombre',
        'registroSeleccionado.descripcion' => 'descripcion'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount() 
    {
        $this->disciplinas = Disciplina::pluck('nombre', 'id')->toArray();
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;

        $paquete = Paquete::find($this->registroSeleccionado['id']);
        $this->selectedDisciplinas = $paquete->disciplinas->pluck('id')->toArray();
    }

    public function cancelar()
    {
        $this->emitTo('paquete.show','cerrarVista');
    }

    public function actualizarPaquete() 
    {
        $this->validate([
            'registroSeleccionado.nombre' => 'required|max:50',
            'registroSeleccionado.descripcion' => 'required|max:100',
            'selectedDisciplinas' => 'required'
        ]);
    
        try {
            // Realiza la actualización del registro seleccionado
            $paquete = Paquete::find($this->registroSeleccionado['id']);

            $paquete->nombre = $this->registroSeleccionado['nombre'];
            $paquete->descripcion = $this->registroSeleccionado['descripcion'];

            $paquete->save();

            // Asocia las disciplinas seleccionadas al paquete
            $paquete->disciplinas()->sync($this->selectedDisciplinas);

            $this->emitTo('paquete.show', 'cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.paquete.edit');
    }
}
