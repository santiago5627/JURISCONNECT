<?php

namespace App\Http\Controllers;

use App\Models\Lawyer; // Asegúrate de importar el modelo
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Obtener abogados paginados
            $lawyers = Lawyer::paginate(10);
            
            // Si es una petición AJAX, devolver solo la vista parcial
            if ($request->ajax()) {
                $html = view('profile.partials.lawyers-table', compact('lawyers'))->render();
                
                return response()->json([
                    'html' => $html,
                    'success' => true
                ]);
            }
            
            // Para peticiones normales, devolver la vista completa
            return view('dashboard', compact('lawyers'));
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }
            
            // Para peticiones normales, redirigir con error
            return back()->with('error', 'Error al cargar los datos');
        }
    }
}