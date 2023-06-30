<?php

namespace App\Http\Livewire\AsignarMaquina;

use App\Models\Maquina;
use App\Models\Seccion;
use App\Models\Tipo_Maquina;
use Livewire\Component;

class Create extends Component
{
    public $codigo, $estado, $id_seccion, $id_tipo;
    public $maquinas, $secciones;

    protected $rules = [
        'codigo' => 'required|max:15|unique:MAQUINA,codigo',
        'estado' => 'required',
        'id_seccion' => 'required',
        'id_tipo' => 'required',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('asignar-maquina.show', 'cerrarVista');
    }

    public function guardarMaquina() 
    {
        $this->validate();

        try {
            $maquina = new Maquina;

            $maquina->codigo = $this->codigo;
            $maquina->estado = $this->estado;
            $maquina->id_seccion = $this->id_seccion;
            $maquina->id_tipo = $this->id_tipo;

            $maquina->save();
            $this->emitTo('asignar-maquina.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }

    }

    public function mount() {
        $this->maquinas = Tipo_Maquina::all();
        $this->secciones = Seccion::all();
    }

    public function render()
    {
        return view('livewire.asignar-maquina.create');
    }
}
