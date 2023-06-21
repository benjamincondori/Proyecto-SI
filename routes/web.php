<?php

use App\Http\Controllers\DashboardController;
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


Route::get('/', function(){
    return view('index');
})->name('index');

Route::get('/login', function() {
    return view('login');
})->name('login');

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/administrativos', 'administrativos')->name('dashboard.administrativos');
    Route::get('/entrenadores', 'entrenadores')->name('dashboard.entrenadores');
    Route::get('/clientes', 'clientes')->name('dashboard.clientes');
    Route::get('/inscripciones', 'inscripciones')->name('dashboard.inscripciones');
    Route::get('/usuarios', 'usuarios')->name('dashboard.usuarios');
    Route::get('/roles', 'roles')->name('dashboard.roles');
    Route::get('/permisos', 'permisos')->name('dashboard.permisos');
    Route::get('/disciplinas', 'disciplinas')->name('dashboard.disciplinas');
    Route::get('/secciones', 'secciones')->name('dashboard.secciones');
    Route::get('/maquinas', 'maquinas')->name('dashboard.maquinas');
    Route::get('/horarios', 'horarios')->name('dashboard.horarios');
    Route::get('/grupos', 'grupos')->name('dashboard.grupos');
    Route::get('/paquetes', 'paquetes')->name('dashboard.paquetes');
    Route::get('/duraciones', 'duraciones')->name('dashboard.duraciones');
    Route::get('/casilleros', 'casilleros')->name('dashboard.casilleros');
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


