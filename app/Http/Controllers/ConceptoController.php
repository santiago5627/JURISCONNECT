<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;

class ConceptoController extends Controller
{
    public function create()
    {
        return view('legal_processes.createConceptos');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        Concepto::create($request->all());

        return redirect()->route('dashboard.abogado')->with('success', 'Concepto jurídico creado correctamente.');
    }
}
