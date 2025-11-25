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

    public function storeProceso(Request $request, $id)
{
    // Validación
    $validated = $request->validate([
        'titulo' => 'required|string|max:120',
        'concepto' => 'required|string|min:50',
    ]);

    // Crear concepto relacionado al proceso
    $concepto = new ConceptoJuridico();
    $concepto->proceso_id = $id;
    $concepto->abogado_id = auth()->id();
    $concepto->titulo = $validated['titulo'];
    $concepto->descripcion = $validated['concepto'];
    $concepto->save();

    return back()->with('success', 'Concepto jurídico creado correctamente.');
}


    public function index(Request $request)
    {
        try {
            // Iniciar query builder
            $query = Proceso::query();
            $searchTerm = $request->get('search');

            // Aplicar búsqueda si existe el término de búsqueda
            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('id', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('estado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('created_at', 'LIKE', '%' . $searchTerm . '%');
                      // Agrega más campos según tu modelo Lawyer 
                });
            }

            // Obtener abogados paginados
            $procesos = $query->paginate(10);

            // Mantener parámetros de búsqueda en la paginación
            $procesos->appends($request->query());

            // Si es una petición AJAX, devolver solo la vista parcial
            if ($request->ajax()) {
                $html = view('profile.partials.lawyers-table', compact('lawyers'))->render();

                return response()->json([
                    'html' => $html,
                    'success' => true,
                    'total' => $procesos->total(),
                    'current_page' => $procesos->currentPage(),
                    'last_page' => $procesos->lastPage(),
                    'search_term' => $searchTerm
                ]);
            }


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

            // Para peticiones normales, redirigir con error
            return back()->with('error', 'Error al cargar los datos');
        }
    }

    /**
 * Show the form for creating a new resource
 */
public function create(Request $request) 
{
    $query = Proceso::where('estado', 'Pendiente'); // Solo procesos pendientes

    // Búsqueda
    if ($request->has('search') && $request->get('search')) {
        $search = $request->get('search');
        $query->where(function($q) use ($search) {
            $q->where('id', 'LIKE', '%' . $search . '%')
              ->orWhere('numero_radicado', 'LIKE', '%' . $search . '%')
              ->orWhere('demandante', 'LIKE', '%' . $search . '%')
              ->orWhere('demandado', 'LIKE', '%' . $search . '%')
              ->orWhere('tipo_proceso', 'LIKE', '%' . $search . '%')
              ->orWhere('created_at', 'LIKE', '%' . $search . '%');
        });
    }

    $procesos = $query->orderBy('created_at', 'desc')->get();

    // Respuesta AJAX
    if ($request->ajax() || $request->get('ajax')) {
        $processes = $procesos; // Renombrar para la vista parcial
        $html = view('profile.partials.process-card', ['procesos' => $procesos])->render();
        return response()->json([
            'success' => true,
            'html' => $html,
            'total' => $procesos->count()
        ]);
    }

    return view('legal_processes.showConceptos', compact('procesos')); 
}

    /**
     * Guardar el concepto para un proceso específico
     */
    public function store(Request $request, Proceso $proceso)
{
    $this->validateConceptoData($request);
    
    $this->createConceptoForProceso($request, $proceso);
    $this->updateProcesoEstado($proceso);

    return redirect()->route('abogado.dashboard')
                    ->with('success', 'Concepto jurídico creado exitosamente.');
}

    /**
     * Mostrar el formulario para crear un concepto para un proceso específico
     */
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
    // MÉTODOS PRIVADOS DE APOYO
    // ===============================

    /**
     * Validar datos del concepto
     */
    private function validateConceptoData(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'categoria' => 'required|string|max:255',
        'descripcion' => 'required|min:50'
    ]);
}

    /**
     * Obtener proceso con sus relaciones
     */
    private function getProcesoWithRelations($procesoId)
    {
        return Proceso::with(['cliente', 'abogado'])->findOrFail($procesoId);
    }

    /**
     * Verificar si ya existe un concepto para el proceso
     */
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
            'abogado_id' => auth()->id() // <-- changed from user_id
        ]);
    }

    /**
     * Actualizar estado del proceso
     */
    private function updateProcesoEstado(Proceso $proceso)
    {
        $proceso->update(['estado' => 'con_concepto']);
    }

    // Método adicional para búsqueda rápida (opcional)
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