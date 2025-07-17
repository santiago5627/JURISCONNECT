<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer; // importa el modelo de abogados

class DashboardController extends Controller
{
    public function index()
    {
        $lawyers = Lawyer::all(); // obtiene todos los abogados
        return view('dashboard', compact('lawyers')); // envía a la vista
    }
}
