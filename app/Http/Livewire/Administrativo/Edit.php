<?php

namespace App\Http\Livewire\Administrativo;

use App\Models\Empleado;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public  $registroSeleccionado, $cargo;

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
            'registroSeleccionado.email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('EMPLEADO', 'email')->ignore($registroId)
            ],
            'registroSeleccionado.direccion' => 'required|max:80',
            'registroSeleccionado.telefono' => 'required|max:10',
            'registroSeleccionado.genero' => 'required|max:1',
            'registroSeleccionado.turno' => 'required',
            'registroSeleccionado.fecha_nacimiento' => 'required',
            'registroSeleccionado.fotografia' => 'nullable|sometimes|image|max:2048',
            'cargo' => 'required',
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

    private function obtenerIdRol() {
        if ($this->cargo === 'Administrador') {
            $idRol = Rol::where('nombre', 'Administrador')->value('id');
        } elseif ($this->cargo === 'Recepcionista') {
            $idRol = Rol::where('nombre', 'Recepcionista')->value('id');
        } 
        return $idRol;
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $empleado = Empleado::find($this->registroSeleccionado['id']);
        $this->cargo = $empleado->administrativo->cargo; 
    }

    public function cancelar()
    {
        $this->emitTo('administrativo.show','cerrarVista');
    }

    public function actualizarAdministrativo() 
    {
        $this->validate($this->getUpdateRules());
        
        try {
            // Realizar la actualización del registro seleccionado
            $empleado = Empleado::findOrFail($this->registroSeleccionado['id']);

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

            $usuario = $empleado->usuario;
            $usuario->id_rol = $this->obtenerIdRol();
            $usuario->save();

            $empleado->save();

            $administrativo = $empleado->administrativo;
            $administrativo->cargo = $this->cargo;
            $administrativo->save();

            $this->emitTo('administrativo.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.administrativo.edit');
    }
}
