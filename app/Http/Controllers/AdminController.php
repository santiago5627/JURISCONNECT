<?php

namespace App\Http\Controllers;

use App\Models\Lawyer; // Asegúrate de importar el modelo
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Iniciar query builder
            $query = Lawyer::query();
            $searchTerm = $request->get('search');
            
            // Aplicar búsqueda si existe el término de búsqueda
            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('apellido', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('numero_documento', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('correo', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('telefono', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('especialidad', 'LIKE', '%' . $searchTerm . '%');
                      // Agrega más campos según tu modelo Lawyer
                });
            }
            
            // Si es una petición para obtener todos los datos (para búsqueda híbrida)
            if ($request->get('get_all') && $request->ajax()) {
                $allLawyers = $query->get();
                return response()->json($allLawyers);
            }
            
            // Obtener abogados paginados
            $lawyers = $query->paginate(10);

            // Mantener parámetros de búsqueda en la paginación
            $lawyers->appends($request->query());

            // Si es una petición AJAX, devolver solo la vista parcial
            if ($request->ajax()) {
                $html = view('profile.partials.lawyers-table', compact('lawyers'))->render();

                return response()->json([
                    'html' => $html,
                    'success' => true,
                    'total' => $lawyers->total(),
                    'current_page' => $lawyers->currentPage(),
                    'last_page' => $lawyers->lastPage(),
                    'search_term' => $searchTerm
                ]);
            }

            // Contar total de abogados registrados
            $totalLawyers = Lawyer::count();

            // Para peticiones normales, devolver la vista completa
            return view('dashboard', compact('lawyers', 'totalLawyers'));

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
    
    // Método adicional para búsqueda rápida (opcional)
    public function search(Request $request)
    {
        try {
            $searchTerm = $request->get('term');
            
            if (!$searchTerm) {
                return response()->json([]);
            }
            
            $lawyers = Lawyer::where(function($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('apellido', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('numero_documento', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('correo', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('telefono', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('especialidad', 'LIKE', '%' . $searchTerm . '%');
            })->limit(20)->get(['id', 'nombre', 'apellido', 'numero_documento']);
            
            return response()->json([
                'success' => true,
                'data' => $lawyers,
                'count' => $lawyers->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }
}