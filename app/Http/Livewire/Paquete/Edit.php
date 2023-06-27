<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Disciplina;
use App\Models\Paquete;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado;
    public $selectedDisciplinas = [];
    public $disciplinas = [];
    public $seleccionados = [];
    public $seleccionarNuevo = false;

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
        $this->disciplinas = Disciplina::all();
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;

        $paquete = Paquete::find($this->registroSeleccionado['id']);
        $this->seleccionados = $paquete->disciplinas;
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
            'selectedDisciplinas' => $this->seleccionarNuevo ? 'required' : ''
        ]);
    
        try {
            // Realiza la actualización del registro seleccionado
            $paquete = Paquete::find($this->registroSeleccionado['id']);

            $paquete->nombre = $this->registroSeleccionado['nombre'];
            $paquete->descripcion = $this->registroSeleccionado['descripcion'];

            $paquete->save();
            if ($this->seleccionarNuevo) {
                // Asocia las disciplinas seleccionadas al paquete
                $paquete->disciplinas()->sync($this->selectedDisciplinas);
            }
            $this->emitTo('paquete.show', 'cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $this->emit('error');
        }
    }

    public function render()
    {
        return view('livewire.paquete.edit');
    }
}
