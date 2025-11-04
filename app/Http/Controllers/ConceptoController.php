<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use App\Models\ConceptoJuridico;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConceptoController extends Controller
{
    // ===============================
    // MÉTODOS PRINCIPALES
    // ===============================

    /**
     * Mostrar lista de procesos disponibles para crear conceptos
     */
    public function index(Request $request)
    {
        try {
            $abogadoId = Auth::id();
            $searchTerm = $request->get('search');

            // Obtener procesos asignados al abogado sin concepto
            $query = Proceso::where('abogado_id', $abogadoId)
                ->whereDoesntHave('concepto')
                ->with(['cliente', 'abogado']);

            // Aplicar búsqueda si existe
            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            $procesos = $query->paginate(10)->appends($request->query());

            // Si es AJAX
            if ($request->ajax()) {
                $html = view('legal_processes.partials.procesos-table', compact('procesos'))->render();
                
                return response()->json([
                    'html' => $html,
                    'success' => true,
                    'total' => $procesos->total(),
                    'current_page' => $procesos->currentPage(),
                    'last_page' => $procesos->lastPage(),
                ]);
            }

            return view('legal_processes.create', compact('procesos'));

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar los procesos');
        }
    }

    /**
     * Mostrar formulario para crear concepto de un proceso específico
     */
    public function create()
    {
        $abogadoId = Auth::id();
        
        // Obtener procesos del abogado que NO tienen concepto
        $procesos = Proceso::where('proceso_id', $abogadoId)
            ->whereDoesntHave('concepto')
            ->with(['cliente'])
            ->get();

        if ($procesos->isEmpty()) {
            return redirect()->route('conceptos.index')
                ->with('info', 'No hay procesos disponibles para crear conceptos.');
        }

        return view('legal_processes.conceptos.create', compact('procesos'));
    }

    /**
     * Guardar el concepto jurídico
     */
    public function store(Request $request)
{
    // El proceso_id debe venir en el request
    $validated = $request->validate([
        'proceso_id' => 'required|exists:procesos,id',
        'titulo' => 'required|string|max:255',
        'categoria' => 'required|string|max:255',
        'descripcion' => 'required|string|min:50',
    ]);

    $proceso = Proceso::findOrFail($validated['proceso_id']);
    
    // Verificar autorización
    $this->authorize('create', [ConceptoJuridico::class, $proceso]);

    try {
        DB::beginTransaction();

        // Verificar que no existe concepto
        if ($proceso->concepto()->exists()) {
            throw new \Exception('Este proceso ya tiene un concepto jurídico.');
        }

        // Crear el concepto
        $concepto = ConceptoJuridico::create([
            'proceso_id' => $proceso->id,
            'abogado_id' => Auth::id(),
            'titulo' => $validated['titulo'],
            'categoria' => $validated['categoria'],
            'descripcion' => $validated['descripcion'],
            'estado' => 'activo',
        ]);

        // Actualizar estado del proceso
        $proceso->update(['estado' => 'con_concepto']);

        DB::commit();

        return redirect()->route('conceptos.show', $concepto->id)
            ->with('success', 'Concepto jurídico creado exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()->back()
            ->with('error', 'Error al crear el concepto: ' . $e->getMessage())
            ->withInput();
    }
}

    
    /**
     * Mostrar formulario para editar concepto
     */
    public function edit($conceptoId)
    {
        $concepto = ConceptoJuridico::with('proceso')->findOrFail($conceptoId);
        
        $this->authorize('update', $concepto);

        return view('legal_processes.edit-concepto', compact('concepto'));
    }

    /**
     * Actualizar concepto existente
     */
    public function update(Request $request, $conceptoId)
    {
        $concepto = ConceptoJuridico::findOrFail($conceptoId);
        
        $this->authorize('update', $concepto);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descripcion' => 'required|string|min:50',
        ]);

        try {
            $concepto->update($validated);

            return redirect()->route('conceptos.show', $concepto->id)
                ->with('success', 'Concepto actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar: ' . $e->getMessage())
                ->withInput();
        }
    }

    // ===============================
    // BÚSQUEDA
    // ===============================

    public function search(Request $request)
    {
        try {
            $searchTerm = $request->get('term');

            if (!$searchTerm) {
                return response()->json([]);
            }

            $abogadoId = Auth::id();

            $procesos = Proceso::where('abogado_id', $abogadoId)
                ->whereDoesntHave('concepto')
                ->where(function($q) use ($searchTerm) {
                    $q->where('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%');
                })
                ->limit(20)
                ->get(['id', 'numero_radicado', 'tipo_proceso', 'demandante', 'demandado']);

            return response()->json([
                'success' => true,
                'data' => $procesos,
                'count' => $procesos->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }
}