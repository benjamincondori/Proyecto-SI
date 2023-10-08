<?php

namespace App\Http\Livewire\PerfilInstructor;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component
{
    public $id_instructor, $nombreCompleto, $nombre, $apellido, $email, $direccion, $ci, $telefono;
    public $fechaNacimiento, $especialidad, $genero, $turno, $grupos, $alumnos;
    public $editar = false;
    public $activeTab = 'informacion';
    public $passwordConfirmar, $passwordNuevo, $passwordActual;
    public $showPassword1 = false;
    public $showPassword2 = false;
    public $showPassword3 = false;
    public $subtitle = 'Información Personal';

    protected $rules = [
        'passwordActual' => 'required',
        'passwordNuevo' => 'required|min:5',
        'passwordConfirmar' => 'required',
    ];

    protected $validationAttributes = [
        'passwordActual' => 'clave actual',
        'passwordNuevo' => 'nueva contraseña',
        'passwordConfirmar' => 'confirmar contraseña',
    ];

    protected function getUpdateRules()
    {
        $registroId = $this->id_instructor;

        return [
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('EMPLEADO', 'email')->ignore($registroId)
            ],
            'telefono' => 'required|max:10'
        ];
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName, $this->getUpdateRules());
    }

    public function changeTabs($activeTab, $subtitle) {
        $this->subtitle = $subtitle;
        $this->activeTab = $activeTab;
        $this->resetearCampos();
    }

    public function obtenerUsuario() {
        $usuario = Auth::user();
        return $usuario;
    }

    public function formatoFechaTexto($fecha) {
        $fechaFormateada = Carbon::parse($fecha)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY');
        return $fechaFormateada;
    }

    public function formatoFecha($fecha) {
        $fechaFormateada = Carbon::parse($fecha)->format('d/m/Y');
        return $fechaFormateada;
    }

    public function formatoHora($hora) {
        $horaFormateada = Carbon::parse($hora)->format('H:i A');
        return $horaFormateada;
    }

    public function cancelar() {
        $this->editar = false;
        $this->mount();
    }

    public function actualizarDatos() {
        $this->validate($this->getUpdateRules());
        try {
            $empleado = Empleado::findOrFail($this->id_instructor);
            $empleado->nombres = $this->nombre;
            $empleado->apellidos = $this->apellido;
            $empleado->telefono = $this->telefono;
            $empleado->email = $this->email;
            $empleado->direccion = $this->direccion;

            $guardado = $empleado->save();

            if ($guardado) {
                $usuario = $empleado->usuario;
                $usuario->email = $empleado->email;
                $usuario->save();
            }

            $this->emit('alert', 'actualizado');
            $this->cancelar();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function resetearCampos() {
        $this->passwordConfirmar = null; 
        $this->passwordNuevo = null; 
        $this->passwordActual = null;
        $this->showPassword1 = false;
        $this->showPassword2 = false;
        $this->showPassword3 = false;
        $this->resetValidation();
    }

    public function cambiarContraseña() {
        $this->validate();

        $usuario = $this->obtenerUsuario();
        $usuario = Usuario::findOrFail($usuario->id);

        if (!password_verify($this->passwordActual, $usuario->password)) {
            $this->addError('passwordActual', 'La contraseña actual es incorrecta.');
            return;
        }

        if ($this->passwordNuevo !== $this->passwordConfirmar) {
            $this->addError('passwordConfirmar', 'La confirmación de contraseña no coincide.');
            return;
        }

        $usuario->password = bcrypt($this->passwordNuevo);
        $usuario->save();

        $this->emit('password');
        $this->resetearCampos();
    }

    public function mount() {
        $usuario = $this->obtenerUsuario();
        $empleado = $usuario->empleado;
        $this->id_instructor = $empleado->id;
        $this->nombre = $empleado->nombres;
        $this->apellido = $empleado->apellidos;
        $this->nombreCompleto = $empleado->nombres.' '.$empleado->apellidos;
        $this->email = $empleado->email;
        $this->direccion = $empleado->direccion;
        $this->ci = $empleado->ci;
        $this->telefono = $empleado->telefono;
        $this->fechaNacimiento = $empleado->fecha_nacimiento;
        $this->genero = $empleado->genero;
        $this->especialidad = $empleado->entrenador->especialidad;
        $this->turno = $empleado->turno;
        $this->grupos = $empleado->entrenador->grupos;
        $grupoIds = $this->grupos->pluck('id');

        $clientes = Cliente::select('CLIENTE.*')
            ->join('INSCRIPCION', 'INSCRIPCION.id_cliente', '=', 'CLIENTE.id')
            ->join('GRUPO_INSCRIPCION', 'GRUPO_INSCRIPCION.id_inscripcion', '=', 'INSCRIPCION.id')
            ->join('GRUPO', 'GRUPO.id', '=', 'GRUPO_INSCRIPCION.id_grupo')
            ->join('DETALLE_INSCRIPCION', 'DETALLE_INSCRIPCION.id_inscripcion', '=', 'INSCRIPCION.id')
            ->where('DETALLE_INSCRIPCION.estado', 1)
            ->whereIn('GRUPO.id', $grupoIds)
            ->get();

        $this->alumnos = $clientes;
    }

    public function render()
    {
        return view('livewire.perfil-instructor.show');
    }
}
