<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use App\Models\Historial_Medico;
use Carbon\Carbon;
use Livewire\Component;

class View extends Component
{
    public $id_cliente, $nombre, $apellido, $email, $ci, $telefono;
    public $fechaNacimiento, $genero, $historialMedico;

    protected $listeners = ['verRegistro'];

    public function verRegistro($registroSeleccionado)
    {
        $cliente = Cliente::find($registroSeleccionado['id']);
        $this->id_cliente = $cliente->id;
        $this->nombre = $cliente->nombres;
        $this->apellido = $cliente->apellidos;
        $this->email = $cliente->email;
        $this->ci = $cliente->ci;
        $this->telefono = $cliente->telefono;
        $this->fechaNacimiento = $cliente->fecha_nacimiento;
        $this->genero = $cliente->genero;
        if ($cliente->historialMedico) {
            $this->historialMedico = $cliente->historialMedico->enfermedades;
        }
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
        return view('livewire.cliente.view');
    }
}
