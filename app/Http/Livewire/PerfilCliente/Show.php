<?php

namespace App\Http\Livewire\PerfilCliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component
{
    public $id_cliente, $nombreCompleto, $nombre, $apellido, $email, $ci, $telefono;
    public $fechaNacimiento, $genero, $inscripciones, $alquileres, $pagos, $asistencias;
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
        $registroId = $this->id_cliente;

        return [
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('CLIENTE', 'email')->ignore($registroId)
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
        $horaFormateada = Carbon::parse($hora)->format('H:i:s A');
        return $horaFormateada;
    }

    public function cancelar() {
        $this->editar = false;
        $this->mount();
    }

    public function actualizarDatos() {
        $this->validate($this->getUpdateRules());
        try {
            $cliente = Cliente::findOrFail($this->id_cliente);
            $cliente->nombres = $this->nombre;
            $cliente->apellidos = $this->apellido;
            $cliente->telefono = $this->telefono;
            $cliente->email = $this->email;

            $guardado = $cliente->save();

            if ($guardado) {
                $usuario = $cliente->usuario;
                $usuario->email = $cliente->email;
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
        $cliente = $usuario->cliente;
        $this->id_cliente = $cliente->id;
        $this->nombre = $cliente->nombres;
        $this->apellido = $cliente->apellidos;
        $this->nombreCompleto = $cliente->nombres.' '.$cliente->apellidos;
        $this->email = $cliente->email;
        $this->ci = $cliente->ci;
        $this->telefono = $cliente->telefono;
        $this->fechaNacimiento = $cliente->fecha_nacimiento;
        $this->genero = $cliente->genero;
        $this->inscripciones = $cliente->inscripciones;
        $this->alquileres = $cliente->alquileres;
        $this->pagos = $cliente->pagos;
        $this->asistencias = $cliente->asistencias;
    }

    public function render()
    {
        return view('livewire.perfil-cliente.show');
    }
}
