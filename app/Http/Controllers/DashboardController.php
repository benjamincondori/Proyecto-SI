<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        return view('dashboard.principal'); 
    }

    public function administrativos() {
        return view('dashboard.administrativo');
    }

    public function entrenadores() {
        return view('dashboard.entrenador');
    }

    public function clientes() {
        return view('dashboard.cliente');
    }

    public function inscripciones() {
        return view('dashboard.inscripcion');
    }

    public function usuarios() {
        return view('dashboard.usuarios');
    }

    public function roles() {
        return view('dashboard.roles');
    }

    public function permisos() {
        return view('dashboard.permisos');
    }

    public function asignarPermiso() {
        return view('dashboard.asignar');
    }

    public function disciplinas() {
        return view('dashboard.disciplina');
    }

    public function asignarInstructor() {
        return view('dashboard.asignar-instructor');
    }

    public function secciones() {
        return view('dashboard.seccion');
    }

    public function maquinas() {
        return view('dashboard.maquina');
    }

    public function asignarMaquina() {
        return view('dashboard.asignar-maquina');
    }

    public function horarios() {
        return view('dashboard.horario');
    }

    public function grupos() {
        return view('dashboard.grupo');
    }

    public function paquetes() {
        return view('dashboard.paquete');
    }

    public function duraciones() {
        return view('dashboard.duracion');
    }

    public function asignarDuracion() {
        return view('dashboard.asignar-duracion');
    }

    public function casilleros() {
        return view('dashboard.casillero');
    }

}
