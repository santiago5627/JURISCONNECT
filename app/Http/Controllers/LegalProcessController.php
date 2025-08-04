<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalProcessController extends Controller
{
    public function create()
    {
        return view('legal_processes.create'); // Asegúrate de crear esta vista
    }
}
