<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use App\Models\ConceptoJuridico;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConceptoController extends Controller
{
    // ===============================
    // MÉTODOS PRINCIPALES
    // ===============================

    public function index(Request $request)
    {
        try {
            $query = Proceso::query();
            $searchTerm = $request->get('search');

            // Aplicar búsqueda si existe
            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('id', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('estado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhereRaw("to_char(created_at, 'YYYY-MM-DD') LIKE ?", ['%' . $searchTerm . '%']);
                });
            }

            // Obtener procesos paginados
            $procesos = $query->paginate(10);
            $procesos->appends($request->query());

            // Respuesta AJAX
            if ($request->ajax()) {
                $html = view('profile.partials.lawyers-table', compact('procesos'))->render();

                return response()->json([
                    'html' => $html,
                    'success' => true,
                    'total' => $procesos->total(),
                    'current_page' => $procesos->currentPage(),
                    'last_page' => $procesos->lastPage(),
                    'search_term' => $searchTerm
                ]);
            }

            return view('concepto.index', compact('procesos'));

        } catch (\Exception $e) {
            Log::error('Error en ConceptoController@index', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar los datos');
        }
    }

    /**
     * Mostrar formulario para crear conceptos
     */
    public function create(Request $request) 
    {
        try {
            //  CORRECCIÓN: Filtrar por múltiples estados correctamente
            $query = Proceso::whereIn('estado', [
                'Pendiente',
                'primera_instancia',
                'En curso',
                'Finalizado',
                'en_audiencia',
                'pendiente_fallo',
                'favorable_primera',
                'desfavorable_primera',
                'en_apelacion',
                'conciliacion_pendiente',
                'conciliado',
                'sentencia_ejecutoriada',
                'en_proceso_pago',
                'terminado'
            ]);

            // Búsqueda
            if ($request->has('search') && $request->get('search')) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('numero_radicado', 'LIKE', '%' . $search . '%')
                    ->orWhere('estado', 'LIKE', '%' . $search . '%')
                    ->orWhere('demandante', 'LIKE', '%' . $search . '%')
                    ->orWhere('demandado', 'LIKE', '%' . $search . '%')
                    ->orWhere('tipo_proceso', 'LIKE', '%' . $search . '%')
                    ->orWhereRaw("to_char(created_at, 'YYYY-MM-DD') LIKE ?", ['%' . $search . '%']);
                });
            }

            $procesos = $query->orderBy('created_at', 'desc')->get();

            // Respuesta AJAX
            if ($request->ajax() || $request->get('ajax')) {
                $html = view('profile.partials.process-card', ['procesos' => $procesos])->render();
                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'total' => $procesos->count()
                ]);
            }

            return view('legal_processes.showConceptos', compact('procesos'));

        } catch (\Exception $e) {
            Log::error('Error en ConceptoController@create', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar procesos: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar los procesos');
        }
    }

    public function store(Request $request, Proceso $proceso)
    {
        try {
            $this->validateConceptoData($request);
            
            $this->createConceptoForProceso($request, $proceso);
            $this->updateProcesoEstado($proceso);

            return redirect()->route('abogado.dashboard')
                            ->with('success', 'Concepto jurídico creado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al crear concepto', [
                'proceso_id' => $proceso->id,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al crear el concepto jurídico')->withInput();
        }
    }

    public function verFormulario($procesoId)
    {
        try {
            $proceso = $this->getProcesoWithRelations($procesoId);
            
            $this->checkExistingConcepto($procesoId);
            
            return view('legal_processes.showConceptos', compact('proceso'));

        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de concepto', [
                'proceso_id' => $procesoId,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al cargar el formulario');
        }
    }

    // ===============================
    // MÉTODOS PRIVADOS
    // ===============================

    private function validateConceptoData(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descripcion' => 'required|string|min:50'
        ], [
            'titulo.required' => 'El título es obligatorio',
            'categoria.required' => 'La categoría es obligatoria',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 50 caracteres'
        ]);
    }

    private function getProcesoWithRelations($procesoId)
    {
        return Proceso::with(['cliente', 'abogado'])->findOrFail($procesoId);
    }

    private function checkExistingConcepto($procesoId)
    {
        $conceptoExistente = ConceptoJuridico::where('proceso_id', $procesoId)->first();
        
        if ($conceptoExistente) {
            abort(403, 'Ya existe un concepto para este proceso.');
        }
    }

    /**
     * Crear concepto jurídico para el proceso
     */
    private function createConceptoForProceso(Request $request, Proceso $proceso)
    {
        ConceptoJuridico::create([
            'proceso_id' => $proceso->id,
            'titulo' => $request->titulo,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'user_id' => auth()->id()
        ]);
    }

    private function updateProcesoEstado(Proceso $proceso)
    {
        $proceso->update(['estado' => 'con_concepto']);
    }

    /**
     * Búsqueda rápida
     */
    public function search(Request $request)
    {
        try {
            $searchTerm = $request->get('term');

            if (!$searchTerm) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'count' => 0
                ]);
            }

            $procesos = Proceso::where(function($q) use ($searchTerm) {
                $q->where('id', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('tipo_proceso', 'LIKE', '%' . $searchTerm . '%');
            })
            ->limit(20)
            ->get(['id', 'numero_radicado', 'demandante', 'demandado', 'estado']);

            return response()->json([
                'success' => true,
                'data' => $procesos,
                'count' => $procesos->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en búsqueda de procesos', [
                'term' => $searchTerm ?? 'N/A',
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }
}
