<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbogadoController extends Controller
{
   // AbogadoController.php
public function index()
{
    return view('dashboard-abogado');
}

public function misProcesos()
{
    // Aquí puedes cargar procesos del abogado logueado
}

public function crearConcepto()
{
    // Aquí puedes retornar una vista para emitir conceptos
}

}
