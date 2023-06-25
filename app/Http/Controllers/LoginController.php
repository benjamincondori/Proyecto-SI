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

            switch ($rol) {
                case 'Administrador':
                    return redirect()->intended('dashboard');
                    break;
                case 'Recepcionista':
                    return redirect()->intended('dashboard');
                    break;
                case 'Instructor':
                    return redirect()->intended('instructor/dashboard');
                    break;
                case 'Cliente':
                    return redirect()->intended('cliente/dashboard');
                    break;
                default:
                    return redirect()->intended('/');
                    break;
            }

        }
    
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
