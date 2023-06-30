<?php

namespace App\Http\Livewire\AsignarMaquina;

use App\Models\Maquina;
use App\Models\Seccion;
use App\Models\Tipo_Maquina;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public  $registroSeleccionado;
    public $maquinas, $secciones;

    protected $listeners = ['editarRegistro'];

    protected function getUpdateRules()
    {
        $registroId = $this->registroSeleccionado['id'];

        return [
            'registroSeleccionado.codigo' => [
                'required',
                'max:15',
                Rule::unique('MAQUINA', 'codigo')->ignore($registroId)
            ],
            'registroSeleccionado.estado' => 'required',
            'registroSeleccionado.id_seccion' => 'required',
            'registroSeleccionado.id_tipo' => 'required',
        ];
    }

    protected $validationAttributes = [
        'registroSeleccionado.codigo' => 'codigo',
        'registroSeleccionado.estado' => 'estado',
        'registroSeleccionado.id_seccion' => 'seccion',
        'registroSeleccionado.id_tipo' => 'maquina'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->getUpdateRules());
    }

    public function editarRegistro($registroSeleccionado)
    {
        $this->registroSeleccionado = $registroSeleccionado;
    }

    public function cancelar()
    {
        $this->emitTo('asignar-maquina.show','cerrarVista');
    }

    public function actualizarMaquina() 
    {
        $this->validate($this->getUpdateRules());
    
        try {
            // Realizar la actualización del registro seleccionado
            $maquina = Maquina::find($this->registroSeleccionado['id']);

            $maquina->codigo = $this->registroSeleccionado['codigo'];
            $maquina->id_tipo = $this->registroSeleccionado['id_tipo'];
            $maquina->id_seccion = $this->registroSeleccionado['id_seccion'];
            $maquina->estado = $this->registroSeleccionado['estado'];
        
            $maquina->save();

            $this->emitTo('asignar-maquina.show','cerrarVista');
            $this->emit('alert', 'actualizado');
            $this->registroSeleccionado = null;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->emit('error', $message);
        }
    }

    public function mount() {
        $this->maquinas = Tipo_Maquina::all();
        $this->secciones = Seccion::all();
    }

    public function render()
    {
        return view('livewire.asignar-maquina.edit');
    }
}
