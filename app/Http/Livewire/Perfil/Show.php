<?php

namespace App\Http\Livewire\Perfil;

use App\Models\Empleado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component
{
    public $id_administrativo, $nombreCompleto, $nombre, $apellido, $email, $direccion, $ci, $telefono;
    public $fechaNacimiento, $cargo, $genero, $turno;
    public $editar = false;
    public $passwordCorfirmar, $passwordNuevo, $passwordActual;
    

    protected $rules = [
        'passwordActual' => 'required',
        'passwordNuevo' => 'required',
        'passwordCorfirmar' => 'required',
    ];

    protected function getUpdateRules()
    {
        $registroId = $this->id_administrativo;

        return [
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('EMPLEADO', 'email')->ignore($registroId)
            ],
            'direccion' => 'required|max:80',
            'telefono' => 'required|max:10'
        ];
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName, $this->getUpdateRules());
    }

    public function obtenerUsuario() {
        $usuario = Auth::user();
        return $usuario;
    }

    public function formatoFecha($fecha) {
        $fechaFormateada = Carbon::parse($fecha)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY');
        return $fechaFormateada;
    }

    public function cancelar() {
        $this->editar = false;
        $this->mount();
    }

    public function actualizarDatos() {
        $this->validate($this->getUpdateRules());
        try {
            $empleado = Empleado::findOrFail($this->id_administrativo);
            $empleado->nombres = $this->nombre;
            $empleado->apellidos = $this->apellido;
            $empleado->direccion = $this->direccion;
            $empleado->telefono = $this->telefono;
            $empleado->email = $this->email;

            $guardado = $empleado->save();

            if ($guardado) {
                $usuario = $empleado->usuario;
                $usuario->email = $empleado->email;
                $usuario->save();
            }

            $descripcion = 'Actualizó su información personal';
            registrarBitacora($descripcion);

            $this->emit('alert', 'actualizado');
            $this->cancelar();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function cambiarContraseña() {
        $this->validate();
    }

    public function mount() {
        $usuario = $this->obtenerUsuario();
        $empleado = $usuario->empleado;
        $this->id_administrativo = $empleado->id;
        $this->nombre = $empleado->nombres;
        $this->apellido = $empleado->apellidos;
        $this->nombreCompleto = $empleado->nombres.' '.$empleado->apellidos;
        $this->email = $empleado->email;
        $this->direccion = $empleado->direccion;
        $this->ci = $empleado->ci;
        $this->telefono = $empleado->telefono;
        $this->fechaNacimiento = $empleado->fecha_nacimiento;
        $this->cargo = $empleado->administrativo->cargo;
        $this->genero = $empleado->genero;
        $this->turno = $empleado->turno;
    }

    public function render()
    {
        return view('livewire.perfil.show');
    }
}
