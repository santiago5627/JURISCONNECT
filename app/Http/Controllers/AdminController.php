<?php

namespace App\Http\Controllers;

use App\Models\Lawyer; // Asegúrate de importar el modelo
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Proceso;
use App\Models\Assistant;


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
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('nombre', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('apellido', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('tipo_documento', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('numero_documento', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('correo', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('telefono', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('especialidad', 'ILIKE', '%' . $searchTerm . '%');
                });
            }


            // Si es una petición para obtener todos los datos (para búsqueda híbrida)
            if ($request->get('get_all') && $request->ajax()) {
                $allLawyers = $query->get();
                return response()->json($allLawyers);
            }

            // Obtener abogados paginados
            $lawyers = $query->paginate(10);

            // TABLA PEQUEÑA (mostrar todos)
            $lawyersSimple = Lawyer::paginate(10);

            $abogados = Lawyer::all();

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

            $cases_count = Proceso::count();

            $totalAsistentes = Assistant::count();

            $assistants = Assistant::with('lawyers')->paginate(10); // tabla principal paginada
            $assistantsSimple = Assistant::with('lawyers')->get(); // tabla pequeña (si la necesitas)


            // Para peticiones normales, devolver la vista completa
            return view('dashboard', compact(
                'lawyers',
                'totalLawyers',
                'abogados',
                'lawyersSimple',
                'cases_count',
                'totalAsistentes',
                'assistants',
                'assistantsSimple'
            ));
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

            $lawyers = Lawyer::where(function ($q) use ($searchTerm) {
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
