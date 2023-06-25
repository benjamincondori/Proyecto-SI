<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public  $registroSeleccionado;

    protected $listeners = ['editarRegistro'];

    protected function getUpdateRules()
    {
        $registroId = $this->registroSeleccionado['id'];

        return [
            'registroSeleccionado.ci' => [
                'required',
                'max:10',
                Rule::unique('cliente', 'ci')->ignore($registroId),
            ],
            'registroSeleccionado.nombres' => 'required|max:50',
            'registroSeleccionado.apellidos' => 'required|max:50',
            'registroSeleccionado.email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('cliente', 'email')->ignore($registroId)
            ],
            'registroSeleccionado.telefono' => 'required|max:10',
            'registroSeleccionado.genero' => 'required|max:1',
            'registroSeleccionado.fecha_nacimiento' => 'required',
            'registroSeleccionado.imagen' => 'nullable|sometimes|image|max:2048'
        ];
    }

    protected $validationAttributes = [
        'registroSeleccionado.ci' => 'CI',
        'registroSeleccionado.nombres' => 'nombres',
        'registroSeleccionado.apellidos' => 'apellidos',
        'registroSeleccionado.email' => 'email',
        'registroSeleccionado.telefono' => 'telefono',
        'registroSeleccionado.genero' => 'genero',
        'registroSeleccionado.fecha_nacimiento' => 'fecha nacimiento',
        'registroSeleccionado.imagen' => 'imagen'
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
        $this->emitTo('cliente.show','cerrarVista');
    }

    public function actualizarCliente() 
    {
        $this->validate($this->getUpdateRules());
    
        try {

            // Realizar la actualización del registro seleccionado
            $cliente = Cliente::find($this->registroSeleccionado['id']);

            $cliente->ci = $this->registroSeleccionado['ci'];
            $cliente->nombres = $this->registroSeleccionado['nombres'];
            $cliente->apellidos = $this->registroSeleccionado['apellidos'];
            $cliente->fecha_nacimiento = $this->registroSeleccionado['fecha_nacimiento'];
            $cliente->telefono = $this->registroSeleccionado['telefono'];
            $cliente->email = $this->registroSeleccionado['email'];
            $cliente->genero = $this->registroSeleccionado['genero'];
            $cliente->fotografia = $this->registroSeleccionado['fotografia'];
            $cliente->id_usuario = $this->registroSeleccionado['id_usuario'];
        
            $cliente->save();
            
            $this->emitTo('cliente.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $this->emit('error');
        }
    }

    public function render()
    {
        return view('livewire.cliente.edit');
    }
}
