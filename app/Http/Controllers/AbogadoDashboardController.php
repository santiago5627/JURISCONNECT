<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbogadoDashboardController extends Controller
{
    //
    public function index()
{
    $user = \Illuminate\Support\Facades\Auth::user();
    if (!$user) {
        abort(403, 'Usuario no autenticado.');
    }
    $procesos = $user->procesosAsignados; // relación en el modelo User

    return view('dashboard.abogado', compact('procesos'));
}

}

