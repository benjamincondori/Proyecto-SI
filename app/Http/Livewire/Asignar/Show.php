<?php

namespace App\Http\Livewire\Asignar;

use App\Models\Permiso;
use App\Models\Rol;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    public $roles, $id_rol;
    public $cant = '10';
    public $sort = 'id';
    public $direction = 'asc';

    protected $listeners = [
        'revocarTodos' => 'revocarTodos'
    ];

    public function updatedCant()
    {
        $this->resetPage();
        $this->gotoPage(1);
    }

    public function mount() {
        $this->roles = Rol::whereNotIn('nombre', ['Cliente', 'Instructor'])->get();
    }

    public function nombrePermiso($permisoId) {
        $permiso = Permiso::findOrFail($permisoId);
        return $permiso->nombre;
    }

    public function togglePermiso($idPermiso) {
        if ($this->id_rol) {
            $rol = Rol::find($this->id_rol);
            if ($rol) {
                if ($this->verificarPermiso($idPermiso)) {
                    $rol->permisos()->detach($idPermiso);

                    $descripcion = 'Se revocó el permiso de '.$this->nombrePermiso($idPermiso).' al rol de '.$rol->nombre;
                    registrarBitacora($descripcion);

                    $this->emit('asignar_rol', 'success', '¡Permiso Revocado!', 'El permiso ha sido revocado exitosamente.');
                } else {
                    $rol->permisos()->attach($idPermiso);

                    $descripcion = 'Se asignó el permiso de '.$this->nombrePermiso($idPermiso).' al rol de '.$rol->nombre;
                    registrarBitacora($descripcion);

                    $this->emit('asignar_rol', 'success', '¡Permiso Asignado!', 'El permiso ha sido asignado exitosamente.');
                }
            }
        } else {
            $this->emit('asignar_rol', 'info', 'Oops...', 'Debes seleccionar un rol para que se le asigne el permiso.');
        }
    }

    public function sincronizarTodos() {
        if (verificarPermiso('Asignar_Permisos')) {
            if ($this->id_rol) {
                try {
                    $rol = Rol::findOrFail($this->id_rol);
                    $permisos = Permiso::pluck('id')->toArray();
                    $rol->permisos()->sync($permisos);

                    $descripcion = 'Se asignó todos permisos al rol de '.$rol->nombre;
                    registrarBitacora($descripcion);
    
                    $this->emit('asignar_rol', 'success', '¡Permisos Asignados!', 'Los permisos han sido sincronizados exitosamente.');
                } catch (Exception $e) {
                    $message = $e->getMessage();
                    $this->emit('error', $message);
                }
            }else {
                $this->emit('asignar_rol', 'info', 'Oops...', 'Debes seleccionar un rol.');
            }
        } else {
            $this->emit('accesoDenegado');
        }
    }

    public function revocarTodos() {
        if ($this->id_rol) {
            try {
                $rol = Rol::findOrFail($this->id_rol);
                $rol->permisos()->detach();

                $descripcion = 'Se revocó todos permisos al rol de '.$rol->nombre;
                registrarBitacora($descripcion);

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->emit('error', $message);
            }
        }
    }

    public function verificarPermiso($idPermiso) {
        if ($this->id_rol) {
            $rol = Rol::find($this->id_rol);
            if ($rol) {
                return $rol->permisos->contains('id', $idPermiso);
            }
        }
        return false;
    }

    public function getCantidadRoles($idPermiso) {
        $permiso = Permiso::find($idPermiso);
        if ($permiso) {
            return $permiso->roles()->count();
        }
        return 0;
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

    public function render()
    {
        $permisosPaginados = Permiso::orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        // $permisosPaginados = Permiso::paginate($this->cant);
        $permisos = $permisosPaginados->items();
        return view('livewire.asignar.show', ['permisos' => $permisos, 'permisosPaginados' => $permisosPaginados]);
    }
}
