<?php

use App\Models\Bitacora;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function verificarPermiso($permiso) {
    $usuario = Auth::user();
    $rol = $usuario->rol;
    
    if ($rol && $rol->nombre === 'Administrador') {
        return true; // Permitir acceso completo al rol "Administrador"
    }
    
    return ($rol && $rol->permisos->contains('nombre', $permiso));
}

function registrarBitacora($descripcion) {

    $usuario = Auth::user();

    $roles = ['Cliente', 'Instructor'];

    if ($usuario && !in_array($usuario->rol->nombre, $roles)) {
        Bitacora::create([
            'id_usuario' => $usuario->empleado->id,
            'descripcion' => $descripcion,
        ]);
    }
    
}

