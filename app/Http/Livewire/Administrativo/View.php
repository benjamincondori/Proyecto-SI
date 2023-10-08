<?php

namespace App\Http\Livewire\Administrativo;

use App\Models\Empleado;
use Carbon\Carbon;
use Livewire\Component;

class View extends Component
{
    public $id_administrativo, $nombre, $apellido, $email, $direccion, $ci, $telefono;
    public $fechaNacimiento, $cargo, $genero, $turno;

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $empleado = Empleado::find($registroSeleccionado['id']);
        $this->id_administrativo = $empleado->id;
        $this->nombre = $empleado->nombres;
        $this->apellido = $empleado->apellidos;
        $this->email = $empleado->email;
        $this->direccion = $empleado->direccion;
        $this->ci = $empleado->ci;
        $this->telefono = $empleado->telefono;
        $this->fechaNacimiento = $empleado->fecha_nacimiento;
        $this->cargo = $empleado->administrativo->cargo;
        $this->genero = $empleado->genero;
        $this->turno = $empleado->turno;
    }

    public function formatoFecha($fecha) {
        $fechaFormateada = Carbon::parse($fecha)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY');
        return $fechaFormateada;
    }

    public function cancelar()
    {
        $this->emit('cerrarVista');
    }

    public function render()
    {
        return view('livewire.administrativo.view');
    }
}
