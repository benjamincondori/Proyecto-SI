<?php

namespace App\Http\Livewire\Entrenador;

use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public  $registroSeleccionado, $especialidad;

    protected $listeners = ['editarRegistro'];

    protected function getUpdateRules()
    {
        $registroId = $this->registroSeleccionado['id'];

        return [
            'registroSeleccionado.ci' => [
                'required',
                'max:10',
                Rule::unique('EMPLEADO', 'ci')->ignore($registroId),
            ],
            'registroSeleccionado.nombres' => 'required|max:50',
            'registroSeleccionado.apellidos' => 'required|max:50',
            'registroSeleccionado.email' => 'required|email|max:100',
            'registroSeleccionado.direccion' => 'required|max:80',
            'registroSeleccionado.telefono' => 'required|max:10',
            'registroSeleccionado.genero' => 'required|max:1',
            'registroSeleccionado.turno' => 'required',
            'registroSeleccionado.fecha_nacimiento' => 'required',
            'registroSeleccionado.fotografia' => 'nullable|sometimes|image|max:2048',
            'especialidad' => 'required|max:50',
        ];
    }

    protected $validationAttributes = [
        'registroSeleccionado.ci' => 'CI',
        'registroSeleccionado.nombres' => 'nombres',
        'registroSeleccionado.apellidos' => 'apellidos',
        'registroSeleccionado.email' => 'email',
        'registroSeleccionado.telefono' => 'telefono',
        'registroSeleccionado.genero' => 'genero',
        'registroSeleccionado.direccion' => 'direccion',
        'registroSeleccionado.turno' => 'turno',
        'registroSeleccionado.fecha_nacimiento' => 'fecha nacimiento',
        'registroSeleccionado.fotografia' => 'imagen'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getUpdateRules());
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $empleado = Empleado::find($this->registroSeleccionado['id']);
        $this->especialidad = $empleado->entrenador->especialidad; 
    }

    public function cancelar()
    {
        $this->emitTo('entrenador.show','cerrarVista');
    }

    public function actualizarEntrenador() 
    {
        $this->validate($this->getUpdateRules());
        
        try {

            // Realizar la actualización del registro seleccionado
            $empleado = Empleado::find($this->registroSeleccionado['id']);

            $empleado->ci = $this->registroSeleccionado['ci'];
            $empleado->nombres = $this->registroSeleccionado['nombres'];
            $empleado->apellidos = $this->registroSeleccionado['apellidos'];
            $empleado->fecha_nacimiento = $this->registroSeleccionado['fecha_nacimiento'];
            $empleado->direccion = $this->registroSeleccionado['direccion'];
            $empleado->telefono = $this->registroSeleccionado['telefono'];
            $empleado->email = $this->registroSeleccionado['email'];
            $empleado->genero = $this->registroSeleccionado['genero'];
            $empleado->turno = $this->registroSeleccionado['turno'];
            $empleado->fotografia = $this->registroSeleccionado['fotografia'];
            $empleado->id_usuario = $this->registroSeleccionado['id_usuario'];
            
            $empleado->save();

            $descripcion = 'Se actualizó el entrenador con ID: '.$empleado->id;
            registrarBitacora($descripcion);

            $entrenador = $empleado->entrenador;
            $entrenador->especialidad = $this->especialidad;
            $entrenador->save();

            $this->emitTo('entrenador.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.entrenador.edit');
    }
}
