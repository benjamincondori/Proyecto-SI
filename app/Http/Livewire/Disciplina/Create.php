<?php

namespace App\Http\Livewire\Disciplina;

use App\Models\Disciplina;
use App\Models\Seccion;
use Livewire\Component;

class Create extends Component
{
    public $id_disciplina, $nombre, $descripcion, $precio, $id_seccion;
    public $secciones;

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:150',
        'precio' => 'required',
        'id_seccion' => 'required'
    ];

    public function mount() {
        $this->secciones = Seccion::pluck('nombre', 'id')->toArray();
    }

    public function cancelar()
    {
        $this->emit('cancelarCreacion');
    }

    public function guardarDisciplina() 
    {
        $this->validate();

        Disciplina::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'id_seccion' => $this->id_seccion
        ]);

        $this->emitTo('disciplina.show', 'render');
        $this->emit('registroGuardado');

    }

    public function render()
    {
        return view('livewire.disciplina.create');
    }
}
