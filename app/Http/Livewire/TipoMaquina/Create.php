<?php

namespace App\Http\Livewire\TipoMaquina;

use Livewire\Component;
use App\Models\Tipo_Maquina;

class Create extends Component
{
    public $id_maquina, $nombre, $descripcion;

    protected $rules = [
        'nombre' => 'required|max:50',
        'descripcion' => 'required|max:150'
    ];

    public function cancelar()
    {
        $this->emit('cancelarCreacion');
    }

    public function guardarMaquina() 
    {
        $this->validate();

        Tipo_Maquina::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion
        ]);

        $this->emitTo('tipo-maquina.show', 'render');
        $this->emit('registroGuardado');

    }

    public function render()
    {
        return view('livewire.tipo-maquina.create');
    }
}
