<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Disciplina;
use App\Models\Paquete;
use Livewire\Component;

class Create extends Component
{
    public $id_paquete, $nombre, $descripcion;
    public $disciplinas, $duraciones;
    public $selectedDisciplinas = [];

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:100',
        'selectedDisciplinas' => 'required',
    ];

    protected $validationAttributes = [
        'selectedDisciplinas' => 'disciplina',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function mount() {
        $this->disciplinas = Disciplina::pluck('nombre', 'id')->toArray();
    }

    public function cancelar()
    {
        $this->emitTo('paquete.show','cerrarVista');
    }

    public function guardarPaquete() 
    {
        $this->validate();

        try {
            $paquete = new Paquete;
            $paquete->nombre = $this->nombre;
            $paquete->descripcion = $this->descripcion;

            $guardado = $paquete->save();

            if ($guardado) {
                // Obtén los IDs de las disciplinas seleccionadas
                $disciplinasSeleccionadas = $this->selectedDisciplinas;
    
                // Asocia las disciplinas seleccionadas al paquete
                $paquete->disciplinas()->attach($disciplinasSeleccionadas);
    
                $this->emitTo('paquete.show', 'cerrarVista');
                $this->emit('alert', 'guardado');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.paquete.create');
    }
}
