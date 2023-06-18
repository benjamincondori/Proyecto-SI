<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id_cliente, $ci, $nombres, $apellidos, $email, $telefono, $fecha_nacimiento, $imagen, $genero, $id_usuario;

    protected $rules = [
        'ci' => 'required|max:10|unique:cliente',
        'nombres' => 'required|max:50',
        'apellidos' => 'required|max:50',
        'email' => 'required|email|max:100',
        'telefono' => 'required|max:10',
        'genero' => 'required|max:1',
        'fecha_nacimiento' => 'required',
        'imagen' => 'nullable|sometimes|image|max:2048'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function cancelar() {
        $this->emitTo('cliente.show', 'cerrarVista');
    }

    public function mount() {
        $this->id_cliente = $this->generarID();
    }

    private function generarID() {
        $ultimoID = Cliente::max('id');
        $id = $ultimoID ? $ultimoID + 1 : 2300000000;
        return str_pad($id, 10, '0', STR_PAD_LEFT);
    }

    public function guardarCliente() {

        $this->validate();

        $cliente = new Cliente;

        $cliente->id = $this->id_cliente;
        $cliente->ci = $this->ci;
        $cliente->nombres = $this->nombres;
        $cliente->apellidos = $this->apellidos;
        $cliente->fecha_nacimiento = $this->fecha_nacimiento;
        $cliente->telefono = $this->telefono;
        $cliente->email = $this->email;
        $cliente->genero = $this->genero;
        $cliente->fotografia = $this->imagen;
        $cliente->id_usuario = $this->id_usuario;

        try {
            $cliente->save();
            $this->emitTo('cliente.show', 'cerrarVista');
            $this->emit('alert', 'guardado');
        } catch (\Exception $e) {
            $this->emit('error');
        }
    }

    public function render() {
        return view('livewire.cliente.create');
    }

}
