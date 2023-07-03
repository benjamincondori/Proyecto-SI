<?php

namespace App\Http\Livewire\Horario;

use App\Models\Horario;
use Livewire\Component;

class Create extends Component
{
    public $id_horario, $descripcion, $hora_inicio, $hora_fin;

    protected $rules = [
        'descripcion' => 'required|max:50',
        'hora_inicio' => 'required',
        'hora_fin' => 'required'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('horario.show', 'cerrarVista');
    }

    public function guardarHorario() 
    {
        $this->validate();

        try {
            $horario = new Horario;
            $horario->descripcion = $this->descripcion;
            $horario->hora_inicio = $this->hora_inicio;
            $horario->hora_fin = $this->hora_fin;

            $horario->save();
            $this->emitTo('horario.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.horario.create');
    }
}
