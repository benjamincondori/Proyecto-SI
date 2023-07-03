<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LoginController;
use App\Models\Disciplina;
use App\Models\Duracion;
use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Entrenador_Disciplina;
use App\Models\Paquete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});


Route::middleware(['auth', 'auth.admin'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/administrativos', [DashboardController::class, 'administrativos'])->name('dashboard.administrativos');
    Route::get('/entrenadores', [DashboardController::class, 'entrenadores'])->name('dashboard.entrenadores');
    Route::get('/clientes', [DashboardController::class, 'clientes'])->name('dashboard.clientes');
    Route::get('/inscripciones', [DashboardController::class, 'inscripciones'])->name('dashboard.inscripciones');
    Route::get('/usuarios', [DashboardController::class, 'usuarios'])->name('dashboard.usuarios');
    Route::get('/roles', [DashboardController::class, 'roles'])->name('dashboard.roles');
    Route::get('/permisos', [DashboardController::class, 'permisos'])->name('dashboard.permisos');
    Route::get('/asignar-permisos', [DashboardController::class, 'asignarPermiso'])->name('dashboard.asignarPermiso');
    Route::get('/disciplinas', [DashboardController::class, 'disciplinas'])->name('dashboard.disciplinas');
    Route::get('/asignar-instructor', [DashboardController::class, 'asignarInstructor'])->name('dashboard.asignarInstructor');
    Route::get('/secciones', [DashboardController::class, 'secciones'])->name('dashboard.secciones');
    Route::get('/maquinas', [DashboardController::class, 'maquinas'])->name('dashboard.maquinas');
    Route::get('/asignar-maquinas', [DashboardController::class, 'asignarMaquina'])->name('dashboard.asignarMaquina');
    Route::get('/horarios', [DashboardController::class, 'horarios'])->name('dashboard.horarios');
    Route::get('/grupos', [DashboardController::class, 'grupos'])->name('dashboard.grupos');
    Route::get('/paquetes', [DashboardController::class, 'paquetes'])->name('dashboard.paquetes');
    Route::get('/asignar-duracion', [DashboardController::class, 'asignarDuracion'])->name('dashboard.asignarDuracion');
    Route::get('/duraciones', [DashboardController::class, 'duraciones'])->name('dashboard.duraciones');
    Route::get('/casilleros', [DashboardController::class, 'casilleros'])->name('dashboard.casilleros');
    Route::get('/logout', function () {
        abort(404); 
    });
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'auth.cliente'])->group(function () {
    Route::get('/cliente/dashboard', [ClienteController::class, 'index'])->name('cliente.index');
});

Route::middleware(['auth', 'auth.instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'index'])->name('instructor.index');
});

Route::get('/test', function() {

    $idPaquete = 3;
    $duraciones = Duracion::whereDoesntHave('paquetes', function ($query) use ($idPaquete) {
        $query->where('id_paquete', $idPaquete);
    })->get();

    // $paquete = Paquete::findOrFail(1);
    // $duraciones = $paquete->duraciones;
    return $duraciones;

});





