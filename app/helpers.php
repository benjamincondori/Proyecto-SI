<?php

use Illuminate\Support\Facades\Auth;

function verificarPermiso($permiso) {
    $usuario = Auth::user();
    $rol = $usuario->rol;
    return ($rol && $rol->permisos->contains('nombre', $permiso));
}

