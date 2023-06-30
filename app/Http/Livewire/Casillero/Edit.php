<?php

namespace App\Http\Livewire\Casillero;

use App\Models\Casillero;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public  $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected function getUpdateRules()
    {
        $registroId = $this->registroSeleccionado['id'];

        return [
            'registroSeleccionado.nro' => [
                'required',
                Rule::unique('CASILLERO', 'nro')->ignore($registroId)
            ],
            'registroSeleccionado.tamaño' => 'required|max:10',
            'registroSeleccionado.precio' => 'required'
        ];
    }

    protected $validationAttributes = [
        'registroSeleccionado.nro' => 'nro',
        'registroSeleccionado.tamaño' => 'tamaño',
        'registroSeleccionado.precio' => 'precio'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getUpdateRules());
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('casillero.show','cerrarVista');
    }

    public function actualizarCasillero() 
    {
        $this->validate($this->getUpdateRules());
    
        try {
            // Realizar la actualización del registro seleccionado
            $casillero = Casillero::find($this->registroSeleccionado['id']);

            $casillero->nro = $this->registroSeleccionado['nro'];
            $casillero->tamaño = $this->registroSeleccionado['tamaño'];
            $casillero->precio = $this->registroSeleccionado['precio'];
            $casillero->estado = $this->registroSeleccionado['estado'];
        
            $casillero->save();

            $this->emitTo('casillero.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.casillero.edit');
    }
}
