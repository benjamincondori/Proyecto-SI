<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index() {

        $usuario = Auth::user();
        $cliente = $usuario->cliente;

        return view('cliente.cliente', ['cliente' => $cliente]);
    }
    
}
