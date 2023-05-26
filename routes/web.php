<?php

use App\Http\Controllers\DashboardController;
use App\Models\Disciplina;
use App\Models\Seccion;
use Illuminate\Support\Facades\Route;


Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/administrativos', 'administrativos')->name('dashboard.administrativos');
    Route::get('/entrenadores', 'entrenadores')->name('dashboard.entrenadores');
    Route::get('/disciplinas', 'disciplinas')->name('dashboard.disciplinas');
    Route::get('/secciones', 'secciones')->name('dashboard.secciones');
    Route::get('/maquinas', 'maquinas')->name('dashboard.maquinas');
    Route::get('/horarios', 'horarios')->name('dashboard.horarios');
});

Route::get('/', function(){
    return view('administrativo');
});

Route::get('/test-query', function () {
    try {
        // $results = Empleado::all();
        // $results = DB::table('empleado')->get();
        // $empleados = Empleado::whereHas('administrativos', function ($query) {
        //     $query->whereIn('cargo', ['administrador', 'recepcionista']);
        // })->get();

        // $disciplinas = Disciplina::all();
        // $seccion = $disciplinas->seccion();

        $disciplinas = Disciplina::all();
        $secciones = Seccion::all(); 

        // $disciplinas = Disciplina::with('seccion')->get();

        return $secciones;
    } catch (\Exception $e) {
        return "Error al consultar la base de datos: " . $e->getMessage();
    }
});


