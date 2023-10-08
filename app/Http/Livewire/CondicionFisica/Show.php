<?php

namespace App\Http\Livewire\CondicionFisica;

use App\Models\Cliente;
use App\Models\Condicion_Fisica;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $registroSeleccionado, $verificarPermiso;
    public $vistaCrear = false;
    public $vistaEditar = false;
    public $buscar = '';
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = [
        'cerrarVista' => 'cerrarVista',
        'eliminarRegistro' => 'eliminarRegistro',
    ];

    public function seleccionarRegistro($registroId)
    {
        if (verificarPermiso('CondicionFisica_Editar')) {
            $this->registroSeleccionado = Condicion_Fisica::findOrFail($registroId);
            $this->vistaEditar = true;
            $this->emit('editarRegistro', $this->registroSeleccionado);
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function formatoAltura($altura) {
        $formateado = number_format($altura, 2, ',').' cm';
        return $formateado;
    }

    public function formatoPeso($peso) {
        $formateado = number_format($peso, 2, ',').' kg';
        return $formateado;
    }

    public function formatoFecha($fecha) {
        $fecha = Carbon::parse($fecha)->format('d/m/Y');
        $hora = Carbon::parse($fecha)->format('H:i A');
        return $fecha . ' - ' . $hora;
    }

    public function obtenerNombre($clienteId) {
        $cliente = Cliente::findOrFail($clienteId);
        return $cliente->nombres.' '.$cliente->apellidos;
    }

    public function eliminarRegistro($registroId)
    {
        // Buscar el registro en base al nro
        $registro = Condicion_Fisica::find($registroId);

        // Verificar si el registro existe antes de eliminarlo
        if ($registro) {
            $registro->delete();

            $descripcion = 'Se eliminó el registro de condición física con ID: '.$registro->id.' del cliente con ID: '.$registro->id_cliente;
            registrarBitacora($descripcion);

            $this->registroSeleccionado = null;
        }
    }

    public function agregarNuevo()
    {
        if (verificarPermiso('CondicionFisica_Crear')) {
            $this->vistaCrear = true;
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function cerrarVista()
    {
        $this->vistaCrear = false;
        $this->vistaEditar = false;
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

    public function updatedCant()
    {
        $this->resetPage();
        $this->gotoPage(1);
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function mount() {
        $this->verificarPermiso = verificarPermiso('CondicionFisica_Eliminar');
    }

    public function render()
    {
        $registros = Condicion_Fisica::where('id', 'like', '%' . $this->buscar . '%')
            ->orWhere('altura', 'like', '%' . $this->buscar . '%')
            ->orWhere('peso', 'like', '%' . $this->buscar . '%')
            ->orWhere('nivel', 'like', '%' . $this->buscar . '%')
            ->orWhere('id_cliente', 'like', '%' . $this->buscar . '%')
            ->orWhere('fecha', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.condicion-fisica.show', ['registros' => $registros]);
    }
}
