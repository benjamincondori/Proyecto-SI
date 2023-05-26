<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/administrativos', 'administrativos')->name('dashboard.administrativos');
    Route::get('/entrenadores', 'entrenadores')->name('dashboard.entrenadores');
    Route::get('/disciplinas', 'disciplinas')->name('dashboard.disciplinas');
    Route::get('/secciones', 'secciones')->name('dashboard.secciones');
    Route::get('/maquinas', 'maquinas')->name('dashboard.maquinas');
});

Route::get('/', function(){
    return view('administrativo');
});
