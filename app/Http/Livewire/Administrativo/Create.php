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
        'cargo' => 'required',
        'turno' => 'required',
        'fecha_nacimiento' => 'required',
        'imagen' => 'image|max:2048'
    ];

    public function cancelar()
    {
        $this->emitTo('administrativo.show', 'cerrarVista');
    }

    // public function mount() {
    //     $this->id_empleado = $this->generarID();
    //     $this->tipo_empleado = 'A';
    //     $this->imagen = null;
    //     $this->id_usuario = null;
    // }

    public function generarID()
    {
        $ultimoID = Empleado::max('id');
        $id = $ultimoID ? $ultimoID + 1 : 2000000000;
        return str_pad($id, 10, '0', STR_PAD_LEFT);
    }

    public function guardarAdministrativo() {

        // dd($this->turno);

        $this->validate();

        dd($this->turno);

        // $empleado = Empleado::create([
        //     'id' => $this->generarID(),
        //     'ci' => $this->ci,
        //     'nombres' => $this->nombre,
        //     'apellidos' => $this->apellido,
        //     'fecha_nacimiento' => $this->fecha_nacimiento,
        //     'direccion' => $this->direccion,
        //     'telefono' => $this->telefono,
        //     'email' => $this->email,
        //     'genero' => $this->genero,
        //     'turno' => $this->turno,
        //     'fotografia' => null,
        //     'tipo_empleado' => 'A',
        //     'id_usuario' => null
        // ]);

        $empleado = new Empleado();
        $empleado->id = $this->generarID();
        $empleado->ci = $this->ci;
        $empleado->nombres = $this->nombre;
        $empleado->apellidos = $this->apellido;
        $empleado->fecha_nacimiento = $this->fecha_nacimiento;
        $empleado->direccion = $this->direccion;
        $empleado->telefono = $this->telefono;
        $empleado->email = $this->email;
        $empleado->genero = $this->genero;
        $empleado->turno = $this->turno;
        $empleado->fotografia = null;
        $empleado->tipo_empleado = 'A';
        $empleado->id_usuario = null;

        try {
            $empleado->save();
        } catch (\Exception $e) {
            // Manejar el error aquí, puedes imprimir el mensaje de error para depuración
            echo $e->getMessage();
            // O puedes mostrar un mensaje de error al usuario
            // return redirect()->back()->with('error', 'No se pudo crear el registro de empleado');
        }

        dd($empleado);

        $empleado->administrativo()->create([
            'cargo' => $this->cargo
        ]);

        $this->emitTo('administrativo.show', 'cerrarVista');
        $this->emit('alert', 'guardado');

    }

    public function render()
    {
        return view('livewire.administrativo.create');
    }
}
