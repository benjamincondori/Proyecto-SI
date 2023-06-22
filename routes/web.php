<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Models\Administrativo;
use App\Models\Cliente;
use App\Models\Disciplina;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Paquete;
use App\Models\Seccion;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function() {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/administrativos', [DashboardController::class, 'administrativos'])->name('dashboard.administrativos');
    Route::get('/entrenadores', [DashboardController::class, 'entrenadores'])->name('dashboard.entrenadores');
    Route::get('/clientes', [DashboardController::class, 'clientes'])->name('dashboard.clientes');
    Route::get('/inscripciones', [DashboardController::class, 'inscripciones'])->name('dashboard.inscripciones');
    Route::get('/usuarios', [DashboardController::class, 'usuarios'])->name('dashboard.usuarios');
    Route::get('/roles', [DashboardController::class, 'roles'])->name('dashboard.roles');
    Route::get('/permisos', [DashboardController::class, 'permisos'])->name('dashboard.permisos');
    Route::get('/disciplinas', [DashboardController::class, 'disciplinas'])->name('dashboard.disciplinas');
    Route::get('/secciones', [DashboardController::class, 'secciones'])->name('dashboard.secciones');
    Route::get('/maquinas', [DashboardController::class, 'maquinas'])->name('dashboard.maquinas');
    Route::get('/horarios', [DashboardController::class, 'horarios'])->name('dashboard.horarios');
    Route::get('/grupos', [DashboardController::class, 'grupos'])->name('dashboard.grupos');
    Route::get('/paquetes', [DashboardController::class, 'paquetes'])->name('dashboard.paquetes');
    Route::get('/duraciones', [DashboardController::class, 'duraciones'])->name('dashboard.duraciones');
    Route::get('/casilleros', [DashboardController::class, 'casilleros'])->name('dashboard.casilleros');

    Route::get('/logout', function () {
        abort(404); 
    });
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
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

        // $disciplinas = Disciplina::all();
        // $secciones = Seccion::all(); 

        // $paquetes = Paquete::with('disciplinas')->get();

        $inscripcion = Inscripcion::find(9);
        $paquete = $inscripcion->paquete;
        $disciplinas = $paquete->disciplinas;
        $grupos = [];

        foreach ($disciplinas as $disciplina) {
            $grupos[] = $disciplina->grupos;
        }

        // return $grupos;

        return Grupo::join('disciplina', 'grupo.id_disciplina', '=', 'disciplina.id')
        ->join('disciplina_paquete', 'disciplina.id', '=', 'disciplina_paquete.id_disciplina')
        ->join('paquete', 'disciplina_paquete.id_paquete', '=', 'paquete.id')
        ->join('inscripcion', 'paquete.id', '=', 'inscripcion.id_paquete')
        ->where('inscripcion.id', 14)
        ->select('grupo.*')
        ->get();

        

    } catch (\Exception $e) {
        return "Error al consultar la base de datos: " . $e->getMessage();
    }
});


