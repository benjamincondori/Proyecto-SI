<?php

namespace App\Http\Livewire\Administrativo;

use App\Models\Empleado;
use Livewire\Component;

class Show extends Component
{
    public $vistaFormulario = false;

    protected $listeners = [
        'registroGuardado' => 'volverATabla',
        'cancelarCreacion' => 'volverATabla',
    ];

    public function agregarNuevo()
    {
        $this->vistaFormulario = true;
    }

    public function volverATabla()
    {
        $this->vistaFormulario = false;
    }

    public function render()
    {
        $administrativos = Empleado::all()
            ->where('tipo_empleado', 'A'); 

        return view('livewire.administrativo.show', compact('administrativos'));
    }

}
