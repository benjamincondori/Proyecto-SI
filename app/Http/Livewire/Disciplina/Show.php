<?php

namespace App\Http\Livewire\Disciplina;

use App\Models\Disciplina;
use App\Models\Seccion;
use Livewire\Component;

class Show extends Component
{
    public $disciplinas, $buscar, $registroSeleccionado;
    public $vistaFormulario = false;
    public $mostrarFormularioEditar = false;
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'registroGuardado' => 'volverATabla',
        'cancelarCreacion' => 'volverATabla',
        'cancelarEdicion' => 'volverATabla',
        'registroActualizado' => 'volverATabla',
        'render' => 'render'
    ];

    public function seleccionarDisciplina($registroId)
    {
        $this->registroSeleccionado = Disciplina::findOrFail($registroId);
        $this->emit('editarRegistro', $this->registroSeleccionado);

        $this->mostrarFormularioEditar = true;
    }

    public function eliminarRegistro($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Disciplina::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();

            $this->emitTo('Seccion.Show', 'render');
        }
    }

    public function agregarNuevo()
    {
        $this->vistaFormulario = true;
    }

    public function volverATabla()
    {
        $this->vistaFormulario = false;
        $this->mostrarFormularioEditar = false;
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
