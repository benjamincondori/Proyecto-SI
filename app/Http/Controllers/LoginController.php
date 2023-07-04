<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index() {
        return view('index');
    }

    public function login() {
        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $usuario = Auth::user();
            $rol = $usuario->rol->nombre;

            if ($rol !== 'Cliente' && $rol !== 'Instructor') {
                registrarBitacora('Ha iniciado sesión.');
                return redirect()->route('dashboard');
            } else if($rol === 'Instructor'){
                return redirect()->route('instructor.index');
            } else if($rol === 'Cliente') {
                return redirect()->route('cliente.index');
            } else {
                return redirect()->route('/');
            }

            // switch ($rol) {
            //     case 'Administrador':
            //         return redirect()->route('dashboard');
            //         break;
            //     case 'Recepcionista':
            //         return redirect()->route('dashboard');
            //         break;
            //     case 'Instructor':
            //         return redirect()->route('instructor.index');
            //         break;
            //     case 'Cliente':
            //         return redirect()->route('cliente.index');
            //         break;
            //     default:
            //         return redirect()->route('/');
            //         break;
            // }

        }
    
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        registrarBitacora('Ha cerrado sesión.');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

}
