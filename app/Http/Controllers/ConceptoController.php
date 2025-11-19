<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use App\Models\ConceptoJuridico;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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
        $concepto->titulo = $validated['titulo'];
        $concepto->descripcion = $validated['concepto'];
        $concepto->abogado_id = auth()->id(); // 🔥 ESTA ERA LA LÍNEA QUE FALTABA
        $concepto->save();

        return back()->with('success', 'Concepto jurídico creado correctamente.');
    }


    public function index(Request $request)
    {
        try {
            $query = Proceso::query();
            $searchTerm = $request->get('search');

            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('id', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('estado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('created_at', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            $procesos = $query->paginate(10);
            $procesos->appends($request->query());

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
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los datos: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar los datos');
        }
    }


    public function create(Request $request) 
    {
        $query = Proceso::where('estado', 'Pendiente');

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

        if ($request->ajax() || $request->get('ajax')) {
            $html = view('profile.partials.process-card', ['procesos' => $procesos])->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $procesos->count()
            ]);
        }

        return view('legal_processes.showConceptos', compact('procesos')); 
    }


    public function store(Request $request, Proceso $proceso)
    {
        $this->validateConceptoData($request);
        
        $this->createConceptoForProceso($request, $proceso);
        $this->updateProcesoEstado($proceso);

        return redirect()->route('abogado.dashboard')
                         ->with('success', 'Concepto jurídico creado exitosamente.');
    }


    public function verFormulario($procesoId)
    {
        $proceso = $this->getProcesoWithRelations($procesoId);
        
        $this->checkExistingConcepto($procesoId);
        
        return view('legal_processes.showConceptos', compact('proceso'));
    }

    // ===============================
    // MÉTODOS PRIVADOS
    // ===============================

    private function validateConceptoData(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descripcion' => 'required|min:50'
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
            abort(redirect()->back()->with('error', 'Ya existe un concepto para este proceso.'));
        }
    }

    private function createConceptoForProceso(Request $request)
    {
        $concepto = new ConceptoJuridico();
        $concepto->titulo = $request->titulo;
        $concepto->categoria = $request->categoria;
        $concepto->descripcion = $request->descripcion;
        $concepto->abogado_id = auth()->id(); // 🔥 TAMBIÉN FALTABA AQUÍ
        $concepto->proceso_id = $request->proceso_id ?? null;
        $concepto->save();
    }

    private function updateProcesoEstado(Proceso $proceso)
    {
        $proceso->update(['estado' => 'con_concepto']);
    }


    public function search(Request $request)
    {
        try {
            $searchTerm = $request->get('term');

            if (!$searchTerm) {
                return response()->json([]);
            }

            $lawyers = ConceptoJuridico::where(function($q) use ($searchTerm) {
                $q->where('id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('estado', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('created_at', 'LIKE', '%' . $searchTerm . '%');
            })->limit(20)->get(['id', 'demandante', 'demandado', 'numero_radicado']);

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
