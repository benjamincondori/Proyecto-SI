<?php

namespace App\Http\Livewire\Disciplina;

use App\Models\Disciplina;
use App\Models\Seccion;
use Livewire\Component;

class Show extends Component
{
    public $disciplinas, $buscar, $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarDisciplina' => 'eliminarDisciplina'
    ];

    public function seleccionarDisciplina($registroId)
    {
        $this->registroSeleccionado = Disciplina::findOrFail($registroId);
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $this->registroSeleccionado);
    }

    public function eliminarDisciplina($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Disciplina::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();
            $this->registroSeleccionado = null;
            $this->mount();
        }
    }

    public function agregarNuevo()
    {
        $this->vistaCrear = true;
    }

    public function cerrarVista()
    {
        $this->vistaCrear = false;
        $this->vistaEditar = false;
        $this->mount();
    }

    public function mount()
    {
        $this->disciplinas = Disciplina::with('seccion')->get();
    }

    public function obtenerNombreSeccion($idSeccion)
    {
        $seccion = Seccion::find($idSeccion);
        return $seccion ? $seccion->nombre : '';
    }

    public function buscar()
    {
        $this->disciplinas = Disciplina::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orWhere('descripcion', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

        $this->render();
    }

    public function render()
    {
        return view('livewire.disciplina.show');
    }
}
