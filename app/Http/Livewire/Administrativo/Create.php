<?php

namespace App\Http\Livewire\Administrativo;

use App\Models\Administrativo;
use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id_empleado, $ci, $nombre, $apellido, $email, $direccion, $telefono, $fecha_nacimiento, $cargo, $turno, $imagen, $genero, $tipo_empleado, $id_usuario;

    protected $rules = [
        'ci' => 'required|max:10',
        'nombre' => 'required|max:50',
        'apellido' => 'required|max:50',
        'email' => 'required|email|max:100',
        'direccion' => 'required|max:80',
        'telefono' => 'required|max:10',
        'genero' => 'required',
        'fecha_nacimiento' => 'required',
        'imagen' => 'image|max:2048'
    ];

    public function mount() {
        $this->id_empleado = $this->generarID();
        $this->cargo = 'Administrador';
        $this->turno = 'Mañana';
        $this->tipo_empleado = 'A';
        $this->imagen = null;
        $this->id_usuario = null;
    }

    public function generarID()
    {
        $ultimoID = Empleado::max('id');
        $id = $ultimoID ? $ultimoID + 1 : 2000000000;
        return str_pad($id, 10, '0', STR_PAD_LEFT);
    }

    public function guardarEmpleado() {

        $this->validate();


        $empleado = Empleado::create([
            'id' => $this->id_empleado,
            'ci' => $this->ci,
            'nombres' => $this->nombre,
            'apellidos' => $this->apellido,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'genero' => $this->genero,
            'turno' => $this->turno,
            'fotografia' => $this->imagen,
            'tipo_empleado' => $this->tipo_empleado,
            'id_usuario' => $this->id_usuario
        ]);


        Administrativo::create([
            'id' => $empleado->id,
            'cargo' => $this->cargo
        ]);


        $this->emit('registroGuardado');
    }

    public function cancelar()
    {
        $this->emit('cancelarCreacion');
    }

    public function render()
    {
        return view('livewire.administrativo.create');
    }
}
