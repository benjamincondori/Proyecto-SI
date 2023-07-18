<?php

namespace App\Http\Livewire\Entrenador;

use App\Models\Empleado;
use Carbon\Carbon;
use Livewire\Component;

class View extends Component
{
    public $id_entrenador, $nombre, $apellido, $email, $direccion, $ci, $telefono;
    public $fechaNacimiento, $especialidad, $genero, $turno, $grupos;

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $empleado = Empleado::find($registroSeleccionado['id']);
        $this->id_entrenador = $empleado->id;
        $this->nombre = $empleado->nombres;
        $this->apellido = $empleado->apellidos;
        $this->email = $empleado->email;
        $this->direccion = $empleado->direccion;
        $this->ci = $empleado->ci;
        $this->telefono = $empleado->telefono;
        $this->fechaNacimiento = $empleado->fecha_nacimiento;
        $this->especialidad = $empleado->entrenador->especialidad;
        $this->genero = $empleado->genero;
        $this->turno = $empleado->turno;
        $this->grupos = $empleado->entrenador->grupos;
    }

    public function formatoFecha($fecha) {
        $fechaFormateada = Carbon::parse($fecha)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY');
        return $fechaFormateada;
    }

    public function formatoHora($hora) {
        $horaFormateada = Carbon::parse($hora)->format('H:i A');
        return $horaFormateada;
    }

    public function cancelar()
    {
        $this->emit('cerrarVista');
    }

    public function mount() {
        $this->grupos = [];
    }

    public function render()
    {
        return view('livewire.entrenador.view');
    }
}
