<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AsistenteController extends Controller
{
    public function index()
    {
        return app(AbogadoController::class)->index();
    }
}
//solucion temporal