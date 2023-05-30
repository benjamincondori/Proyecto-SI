<?php

namespace App\Http\Livewire\Disciplina;

use App\Models\Disciplina;
use App\Models\Seccion;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarDisciplina' => 'eliminarDisciplina'
    ];

    protected $queryString = [
        'cant' => ['except' => '10']
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
    }

    public function obtenerNombreSeccion($idSeccion)
    {
        $seccion = Seccion::find($idSeccion);
        return $seccion ? $seccion->nombre : '';
    }

    public function order($sort) 
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        $disciplinas = Disciplina::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.disciplina.show', ['disciplinas' => $disciplinas]);
    }
}
