<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportarController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LoginController;
use App\Http\Livewire\Reporte\ReporteAlquiler;
use App\Http\Livewire\Reporte\ReporteAsistencia;
use App\Http\Livewire\Reporte\ReporteInscripcion;
use App\Http\Livewire\Reporte\ReportePago;
use App\Models\Disciplina;
use App\Models\Duracion;
use App\Models\Empleado;
use App\Models\Entrenador;
use App\Models\Entrenador_Disciplina;
use App\Models\Maquina;
use App\Models\Pago;
use App\Models\Paquete;
use App\Models\Paquete_Duracion;
use App\Models\Seccion;
use App\Models\Tipo_Maquina;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    Route::get('/condicion-fisica', [DashboardController::class, 'condicionFisica'])->name('dashboard.condicionFisica');
    Route::get('/inscripciones', [DashboardController::class, 'inscripciones'])->name('dashboard.inscripciones');
    Route::get('/alquileres', [DashboardController::class, 'alquileres'])->name('dashboard.alquileres');
    Route::get('/registro-asistencia', [DashboardController::class, 'asistencia'])->name('dashboard.asistencia');
    Route::get('/pagos', [DashboardController::class, 'pagos'])->name('dashboard.pagos');
    // Route::get('/pagos/{idPago}', [ReporteController::class, 'factura']);
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
    Route::get('/bitacora', [DashboardController::class, 'bitacora'])->name('dashboard.bitacora');
    Route::get('/reporte-inscripcion', [DashboardController::class, 'reporteInscripcion'])->name('dashboard.reporteInscripcion');
    Route::get('/reporte-alquiler', [DashboardController::class, 'reporteAlquiler'])->name('dashboard.reporteAlquiler');
    Route::get('/reporte-pago', [DashboardController::class, 'reportePago'])->name('dashboard.reportePago');
    Route::get('/reporte-asistencia', [DashboardController::class, 'reporteAsistencia'])->name('dashboard.reporteAsistencia');
    // Route::get('/reporte-factura', [DashboardController::class, 'reporteFactura'])->name('dashboard.reporteFactura');
    Route::get('/logout', function () {
        abort(404); 
    });

    // Reportes de inscripciones pdf
    Route::get('/reporteInscripcion-pdf/{admin}/{cliente}/{tipo}/{estado}/{paquete}/{duracion}/{f1}/{f2}', [ReporteInscripcion::class, 'generarPDF']);
    Route::get('/reporteInscripcion-pdf/{admin}/{cliente}/{tipo}/{estado}/{paquete}/{duracion}', [ReporteInscripcion::class, 'generarPDF']);

    // Reportes de alquileres pdf
    Route::get('/reporteAlquiler-pdf/{admin}/{cliente}/{tipo}/{estado}/{casillero}/{f1}/{f2}', [ReporteAlquiler::class, 'generarPDF']);
    Route::get('/reporteAlquiler-pdf/{admin}/{cliente}/{tipo}/{estado}/{casillero}', [ReporteAlquiler::class, 'generarPDF']);

    // Reportes de alquileres pdf
    Route::get('/reportePago-pdf/{admin}/{cliente}/{tipo}/{estado}/{concepto}/{f1}/{f2}', [ReportePago::class, 'generarPDF']);
    Route::get('/reportePago-pdf/{admin}/{cliente}/{tipo}/{estado}/{concepto}', [ReportePago::class, 'generarPDF']);

    // Reportes de asistencias pdf
    Route::get('/reporteAsistencia-pdf/{admin}/{cliente}/{tipo}/{f1}/{f2}', [ReporteAsistencia::class, 'generarPDF']);
    Route::get('/reporteAsistencia-pdf/{admin}/{cliente}/{tipo}', [ReporteAsistencia::class, 'generarPDF']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'auth.cliente'])->group(function () {
    Route::get('/cliente/dashboard', [ClienteController::class, 'index'])->name('cliente.index');
});

Route::middleware(['auth', 'auth.instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'index'])->name('instructor.index');
});


// Route::get('/test', function() {

//     $seccionId = 3; 

//     function cantidadTiposMaquina($seccionId) {
//         // $cantidadTiposMaquina = Maquina::join('tipo_maquina', 'maquina.id_tipo', '=', 'tipo_maquina.id')
//         //     ->where('maquina.id_seccion', $seccionId)
//         //     ->distinct('tipo_maquina.id')
//         //     ->count('tipo_maquina.id');

//         $idsTiposMaquina = Maquina::join('tipo_maquina', 'maquina.id_tipo', '=', 'tipo_maquina.id')
//             ->where('maquina.id_seccion', $seccionId)
//             ->distinct('tipo_maquina.id')
//             ->pluck('tipo_maquina.id');
//         return $idsTiposMaquina;
//     }
    
//     function cantidadMaquinas($tipoId, $seccionId) {
//         $cantidadMaquinas = DB::table('maquina')
//             ->join('tipo_maquina', 'maquina.id_tipo', '=', 'tipo_maquina.id')
//             ->where('maquina.id_tipo', $tipoId)
//             ->where('maquina.id_seccion', $seccionId)
//             ->where('maquina.estado', 1)
//             ->count();
//         return $cantidadMaquinas;
//     }

//     function obtenerCupos($seccionId) {
//         $tiposMaquina = cantidadTiposMaquina($seccionId);
//         $cupo = 0;
//         foreach ($tiposMaquina as $tipoId) {
//             $maquinas = cantidadMaquinas($tipoId, $seccionId);
//             if ($maquinas < $cupo || $cupo == 0) {
//                 $cupo = $maquinas;
//             }
//         }
//         return $cupo;
//     }
//     return obtenerCupos($seccionId);
// });



