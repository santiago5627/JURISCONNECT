<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class AsistenteController extends Controller
{
    public function index()
    {
        return app(AbogadoController::class)->index();
    }
}
//solucion temporal