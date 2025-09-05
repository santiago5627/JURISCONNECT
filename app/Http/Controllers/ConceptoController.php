<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso; // Ajusta según tu modelo

class ConceptoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Si no tienes datos, crea una colección vacía para evitar errores
        //$procesos = collect([]); // Colección vacía temporal
        
        // O mejor aún, obtén los datos reales:
         $procesos = Proceso::all();
        
        return view('legal_processes.createConceptos', compact('procesos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Tu lógica para guardar
    }
    
    // Otros métodos...
}