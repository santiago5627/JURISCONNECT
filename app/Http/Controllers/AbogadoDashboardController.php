<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class AbogadoDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Usuario no autenticado.');
        }

        // Obtener SOLO los procesos donde lawyer_id = id del abogado
        $procesos = $user->procesosAsignados;

        return view('dashboard.abogado', compact('procesos'));
    }
}
