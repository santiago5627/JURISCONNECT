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
            $lawyers = $query
                ->orderBy('id', 'desc') // o 'asc'
                ->paginate(10, ['*'], 'lawyersPage');


            // TABLA PEQUEÑA (mostrar todos)
            $lawyersSimple = Lawyer::orderBy('id', 'desc')
                ->paginate(10, ['*'], 'lawyersSimplePage');


            $assistants = Assistant::with('lawyers')
                ->orderBy('id', 'asc')
                ->paginate(10, ['*'], 'assistantsPage');

            $assistantsSimple = Assistant::with('lawyers')
                ->orderBy('id', 'asc')
                ->paginate(10, ['*'], 'assistantsSimplePage');

            $abogados = Lawyer::all();


            // Mantener parámetros de búsqueda en la paginación
            $lawyers->appends(['search' => $searchTerm]);
            $assistants->appends(['search' => $searchTerm]);
            $lawyersSimple->appends(['search' => $searchTerm]);
            $assistantsSimple->appends(['search' => $searchTerm]);

            // Si es una petición AJAX, devolver solo la vista parcial que corresponda
            if ($request->ajax()) {
                if ($request->has('lawyersPage')) {
                    $html = view('profile.partials.lawyers-table', [
                        'lawyers' => $lawyers
                    ])->render();
                } elseif ($request->has('lawyersSimplePage')) {
                    $html = view('profile.partials.lawyers-table-simple', [
                        'lawyersSimple' => $lawyersSimple
                    ])->render();
                } elseif ($request->has('assistantsPage')) {
                    $html = view('profile.partials.assistants-table', [
                        'assistants' => $assistants
                    ])->render();
                } elseif ($request->has('assistantsSimplePage')) {
                    $html = view('profile.partials.assistants-table-simple', [
                        'assistantsSimple' => $assistantsSimple
                    ])->render();
                }
                return response()->json([
                    'html' => $html,
                    'success' => true
                ]);
            }

            // Contar total de abogados registrados
            $totalLawyers = Lawyer::count();

            $cases_count = Proceso::count();

            $totalAsistentes = Assistant::count();


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
