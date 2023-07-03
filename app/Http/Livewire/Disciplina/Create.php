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

    protected $validationAttributes = [
        'id_seccion' => 'seccion'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function mount() {
        $this->secciones = Seccion::pluck('nombre', 'id')->toArray();
    }

    public function cancelar()
    {
        $this->emitTo('disciplina.show', 'cerrarVista');
    }

    public function guardarDisciplina() 
    {
        $this->validate();

        try {
            $disciplina = new Disciplina;

            $disciplina->nombre = $this->nombre;
            $disciplina->descripcion = $this->descripcion;
            $disciplina->precio = $this->precio;
            $disciplina->id_seccion = $this->id_seccion;

            $disciplina->save();
            $this->emitTo('disciplina.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function render()
    {
        return view('livewire.disciplina.create');
    }
}
