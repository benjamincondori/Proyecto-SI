<?php

namespace App\Http\Livewire\Usuario;

use App\Models\Empleado;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $registroSeleccionado, $nombres, $apellidos;
    public $roles;

    protected $listeners = ['editarRegistro'];

    protected function getUpdateRules()
    {
        $registroId = $this->registroSeleccionado['id'];

        return [
            'registroSeleccionado.email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('USUARIO', 'email')->ignore($registroId)
            ],
            'registroSeleccionado.id_rol' => 'required',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
        ];
    }

    protected $validationAttributes = [
        'registroSeleccionado.email' => 'email',
        'registroSeleccionado.id_rol' => 'rol'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getUpdateRules());
    }

    public function mount() 
    {
        $this->roles = Rol::whereNotIn('nombre', ['Cliente', 'Instructor'])->get();
    }

    public function obtenerEmpleado($usuarioId) {
        $usuario = Usuario::findOrFail($usuarioId);
        $empleado = $usuario->empleado;
        return $empleado;
    }

    public function obtenerAdministrativo($empleadoId) {
        $empleado = Empleado::findOrFail($empleadoId);
        $administrativo = $empleado->administrativo;
        return $administrativo;
    }

    public function obtenerNombreRol($rolId) {
        $rol = Rol::findOrFail($rolId);
        $nombre = $rol->nombre;
        return $nombre;
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
        $empleado = $this->obtenerEmpleado($this->registroSeleccionado['id']);
        $this->nombres = $empleado->nombres;
        $this->apellidos = $empleado->apellidos;
    }

    public function cancelar()
    {
        $this->emitTo('usuario.show','cerrarVista');
    }

    public function actualizarUsuario() 
    {
        $this->validate($this->getUpdateRules());
    
        try {
            // Realiza la actualización del registro seleccionado
            $usuario = Usuario::findOrFail($this->registroSeleccionado['id']);

            $usuario->email = $this->registroSeleccionado['email'];
            $usuario->id_rol = $this->registroSeleccionado['id_rol'];

            $usuario->save();

            $descripcion = 'Se actualizó el usuario con ID: '.$usuario->id;
            registrarBitacora($descripcion);

            $empleado = $usuario->empleado;

            if ($empleado) {
                $empleado->nombres = $this->nombres;
                $empleado->apellidos = $this->apellidos;
                $empleado->email = $usuario->email;
                $empleado->save();

                $administrativo = $this->obtenerAdministrativo($empleado->id);
                $administrativo->cargo = $this->obtenerNombreRol($usuario->id_rol);
                $administrativo->save();
            }

            $this->emitTo('usuario.show', 'cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.usuario.edit');
    }
}
