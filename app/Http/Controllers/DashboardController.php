<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer; // Importa el modelo de abogados

class DashboardController extends Controller
{
    public function index()
    {
        $lawyers = Lawyer::all(); // Obtiene todos los abogados
        return view('dashboard', compact('lawyers')); // Envía a la vista
    }
}
