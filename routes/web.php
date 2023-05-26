<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'dashboard']);

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/administrativos', 'administrativos')->name('dashboard.administrativos');
    Route::get('/entrenadores', 'entrenadores')->name('dashboard.entrenadores');
    Route::get('/disciplinas', 'disciplinas')->name('dashboard.disciplinas');
    Route::get('/secciones', 'secciones')->name('dashboard.secciones');
    Route::get('/maquinas', 'maquinas')->name('dashboard.maquinas');

    Route::get('/horario', 'horario')->name('dashboard.horario');
});