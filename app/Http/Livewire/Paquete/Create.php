<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Disciplina;
use App\Models\Paquete;
use Livewire\Component;

class Create extends Component
{
    public $id_paquete, $nombre, $descripcion;
    public $disciplinas;
    public $selectedDisciplinas = [];

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:100',
        'selectedDisciplinas' => 'required'
    ];

    public function mount() {
        $this->disciplinas = Disciplina::pluck('nombre', 'id')->toArray();
    }

    // Cierra la vista de creación
    public function cancelar()
    {
        $this->emitTo('paquete.show','cerrarVista');
    }

    public function guardarPaquete() 
    {
        $this->validate();

        $paquete = Paquete::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);

        // Obtén los IDs de las disciplinas seleccionadas
        $disciplinasSeleccionadas = $this->selectedDisciplinas;

        // Asocia las disciplinas seleccionadas al paquete
        $paquete->disciplinas()->attach($disciplinasSeleccionadas);

        $this->emitTo('paquete.show', 'cerrarVista');
        $this->emit('alert', 'guardado');
    }

    public function render()
    {
        return view('livewire.paquete.create');
    }
}
