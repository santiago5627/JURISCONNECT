<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class AsistenteController extends Controller
{
    // En tu controlador de asistentes

// Para crear
public function store(Request $request)
{
    // ... lógica de creación
    
    return redirect()->route('asistentes.index')
        ->with('success', 'Asistente jurídico creado exitosamente');
}

// Para actualizar
public function update(Request $request, $id)
{
    // ... lógica de actualización
    
    return redirect()->route('asistentes.index')
        ->with('update', 'Asistente jurídico actualizado exitosamente');
}

// Para eliminar
public function destroy($id)
{
    // ... lógica de eliminación
    
    return redirect()->route('asistentes.index')
        ->with('delete', 'Asistente jurídico eliminado exitosamente');
}
}
//solucion temporal