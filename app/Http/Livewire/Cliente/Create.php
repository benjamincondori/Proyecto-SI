<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id_cliente, $ci, $nombre, $apellido, $email, $telefono, $fecha_nacimiento,  $imagen, $genero, $id_usuario;

    protected $rules = [
        'ci' => 'required|max:10',
        'nombre' => 'required|max:50',
        'apellido' => 'required|max:50',
        'email' => 'required|email|max:100',
        'telefono' => 'required|max:10',
        'genero' => 'required',
        'fecha_nacimiento' => 'required',
        'imagen' => 'image|max:2048'
    ];

    public function cancelar()
    {
        $this->emitTo('cliente.show', 'cerrarVista');
    }

    public function generarID()
    {
        $ultimoID = Cliente::max('id');
        $id = $ultimoID ? $ultimoID + 1 : 2300000000;
        return str_pad($id, 10, '0', STR_PAD_LEFT);
    }

    public function guardarCliente() {

        $this->validate();

        $cliente = Cliente::create([
            'id' => $this->generarID(),
            'ci' => $this->ci,
            'nombres' => $this->nombre,
            'apellidos' => $this->apellido,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'genero' => $this->genero,
            'fotografia' => null,
            'id_usuario' => null
        ]);

        $this->emitTo('cliente.show', 'cerrarVista');
        $this->emit('alert', 'guardado');

    }

    public function render()
    {
        return view('livewire.cliente.create');
    }
}
