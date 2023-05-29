<?php

namespace App\Http\Livewire\TipoMaquina;

use Livewire\Component;
use App\Models\Tipo_Maquina;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $maquina, $registroSeleccionado;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar;
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarMaquina' => 'eliminarMaquina'
    ];

    public function seleccionarMaquina(Tipo_Maquina $maquina)
    {
        $this->vistaEditar = true;
        $this->emit('editarRegistro', $maquina);
    }

    public function eliminarMaquina($registroId)
    {
        // Buscar el registro en base al ID
        $registro = Tipo_Maquina::find($registroId);

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
        // $this->maquinas = Tipo_Maquina::All();
    }

    public function render()
    {
        $maquinas = Tipo_Maquina::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate(10);

        return view('livewire.tipo-maquina.show', ['maquinas' => $maquinas]);
    }
}
