<?php

namespace App\Http\Livewire\Entrenador;

use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Rol;
use App\Models\Usuario;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id_empleado, $ci, $nombres, $apellidos, $email, $direccion, $telefono, $fecha_nacimiento, $especialidad, $turno, $fotografia, $genero, $tipo_empleado, $id_usuario;

    protected $rules = [
        'ci' => 'required|max:10|unique:EMPLEADO',
        'nombres' => 'required|max:50',
        'apellidos' => 'required|max:50',
        'email' => 'required|email|max:100',
        'direccion' => 'required|max:80',
        'telefono' => 'required|max:10',
        'genero' => 'required|max:1',
        'especialidad' => 'required|max:50',
        'turno' => 'required',
        'fecha_nacimiento' => 'required',
        'fotografia' => 'nullable|sometimes|image|max:2048'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar()
    {
        $this->emitTo('entrenador.show', 'cerrarVista');
    }

    public function mount() {
        $this->id_empleado = $this->generarID();
        $this->tipo_empleado = 'E';
    }

    public function generarID()
    {
        $ultimoID = Empleado::max('id');
        $id = $ultimoID ? $ultimoID + 1 : 2000000000;
        return str_pad($id, 10, '0', STR_PAD_LEFT);
    }

    private function obtenerIdRol() {
        $idRol = Rol::where('nombre', 'Instructor')->value('id');
        return $idRol;
    }

    public function guardarEntrenador() {

        $this->validate();

        try {

            $empleado = new Empleado();

            $empleado->id = $this->id_empleado;
            $empleado->ci = $this->ci;
            $empleado->nombres = $this->nombres;
            $empleado->apellidos = $this->apellidos;
            $empleado->fecha_nacimiento = $this->fecha_nacimiento;
            $empleado->direccion = $this->direccion;
            $empleado->telefono = $this->telefono;
            $empleado->email = $this->email;
            $empleado->genero = $this->genero;
            $empleado->turno = $this->turno;
            $empleado->fotografia = $this->fotografia;
            $empleado->tipo_empleado = $this->tipo_empleado;

            $usuario = Usuario::create([
                'email' => $this->email,
                'password' => bcrypt($this->ci),
                'id_rol' => $this->obtenerIdRol()
            ]);

            $empleado->id_usuario = $usuario->id;
        
            $empleado->save();

            $descripcion = 'Se creó un nuevo entrenador con ID: '.$this->id_empleado;
            registrarBitacora($descripcion);

            Entrenador::create([
                'id' => $this->id_empleado,
                'especialidad' => $this->especialidad
            ]);
    
            $this->emitTo('entrenador.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function render()
    {
        return view('livewire.entrenador.create');
    }
}
