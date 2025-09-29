<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use Illuminate\Support\Facades\Storage;


class LegalProcessController extends Controller
{
    // ===============================
    // CRUD BÁSICO
    // ===============================

    /**
     * Listar procesos judiciales
     */
    public function index(Request $request)
    {
        try{
            // iniciar query builder
            $query = Proceso::query();
            $searchTerm = $request->get('search');

            // aplicar búsqueda si existe el término de búsqueda
            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('descripcion', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('estado', 'LIKE', '%' . $searchTerm . '%');
                      // Agrega más campos según tu modelo Proceso
                });
        }

        // Obtener procesos paginados
        $procesos = $query->latest()->paginate(10);

        // Mantener parámetros de búsqueda en la paginación
        $procesos->appends($request->query());

        // Si es una petición AJAX, devolver solo la vista parcial
        if ($request->ajax()) {
            $html = view('legal_processes.index', compact('procesos'))->render();

            return response()->json([
                'html' => $html,
                'success' => true,
                'total' => $procesos->total(),
                'current_page' => $procesos->currentPage(),
                'last_page' => $procesos->lastPage(),
                'search_term' => $searchTerm
            ]);
        }

        //contar total de procesos registrados
        $totalProcesos = Proceso::count();

       //para peticiones normales, devolver la vista completa
        return view('legal_processes.index', compact('procesos', 'totalProcesos')); 

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

    //metodo para busqueda rapida
    public function search(Request $request)
    {
        try {
        $searchTerm = $request->input('query');

        if (!$searchTerm) {
            return response()->json([]);
        }

        $procesos = Proceso::where(function($q) use ($searchTerm) {
                $q->where('tipo_proceso', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('numero_radicado', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('demandante', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('demandado', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('descripcion', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('estado', 'LIKE', '%' . $searchTerm . '%');
            })->limit(20)->get(['id', 'numero_radicado', 'tipo_proceso', 'demandante', 'demandado', 'estado']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }    

    /**
     * Mostrar formulario para crear proceso judicial
     */
    public function create()
    {
        return view('legal_processes.create');
    }

    /**
     * Guardar nuevo proceso judicial
     */
    public function store(Request $request)
    {
        $validated = $this->validateProcesoData($request);
        
        $this->handleDocumentUpload($request, $validated);
        
        Proceso::create(array_merge($validated, [
    'estado' => 'pendiente' // o el estado inicial que corresponda
]));

        return redirect()
            ->route('procesos.index')
            ->with('success', 'Proceso judicial creado con éxito.');
    }

    /**
     * Mostrar un proceso específico
     */
    public function show($id)
    {
        $proceso = Proceso::findOrFail($id);
        return response()->json($proceso);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $proceso = Proceso::findOrFail($id);
        return view('legal_processes.editProcesos', compact('proceso'));
    }

    /**
     * Actualizar proceso judicial
     */
    public function update(Request $request, $id)
    {
        $proceso = Proceso::findOrFail($id);
        
        $validated = $this->validateProcesoDataForUpdate($request, $id);
        
        $this->handleDocumentUpdateOperation($request, $proceso, $validated);
        
        $this->removeAuxiliaryFields($validated);
        
        $proceso->update($validated);

        return redirect()
            ->route('procesos.show', $proceso->id)
            ->with('success', 'Proceso actualizado correctamente.');
    }

    /**
     * Eliminar proceso judicial
     */
    public function destroy($id)
    {
        $proceso = Proceso::findOrFail($id);

        $this->deleteAssociatedDocument($proceso);
        
        $proceso->delete();

        return redirect()
            ->route('procesos.index')
            ->with('success', 'Proceso eliminado correctamente.');
    }

    // ===============================
    // MÉTODOS PRIVADOS DE APOYO
    // ===============================

    /**
     * Validar datos del proceso para creación
     */
    private function validateProcesoData(Request $request)
    {
        return $request->validate([
            'tipo_proceso'      => 'required|string|max:100',
            'numero_radicado'   => 'required|string|max:50|unique:procesos,numero_radicado',
            'demandante'        => 'required|string|max:255',
            'demandado'         => 'required|string|max:255',
            'descripcion'       => 'required|string',
            'documento'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'estado'            => 'required|string',
        ]);
    }

    /**
     * Validar datos del proceso para actualización
     */
    private function validateProcesoDataForUpdate(Request $request, $id)
    {
        return $request->validate([
            'tipo_proceso'      => 'required|string|max:100',
            'numero_radicado'   => 'required|string|max:50|unique:procesos,numero_radicado,' . $id,
            'demandante'        => 'required|string|max:255',
            'demandado'         => 'required|string|max:255',
            'descripcion'       => 'required|string',
            'documento'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'eliminar_documento' => 'nullable|boolean',
            'estado'            => 'required|string',
        ]);
    }

    /**
     * Manejar subida de documento en creación
     */
    private function handleDocumentUpload(Request $request, array &$validated)
    {
        if ($request->hasFile('documento')) {
            $validated['documento'] = $request->file('documento')->store('documentos', 'public');
        }
    }

    /**
     * Manejar operaciones de documento en actualización
     */
    private function handleDocumentUpdateOperation(Request $request, Proceso $proceso, array &$validated)
    {
        if ($request->hasFile('documento')) {
            $this->deleteExistingDocument($proceso);
            $validated['documento'] = $request->file('documento')->store('documentos', 'public');
        } elseif ($request->has('eliminar_documento') && $request->eliminar_documento) {
            $this->deleteExistingDocument($proceso);
            $validated['documento'] = null;
        } else {
            unset($validated['documento']);
        }
    }

    /**
     * Eliminar documento existente del proceso
     */
    private function deleteExistingDocument(Proceso $proceso)
    {
        if ($proceso->documento && Storage::disk('public')->exists($proceso->documento)) {
            Storage::disk('public')->delete($proceso->documento);
        }
    }

    /**
     * Eliminar documento asociado al proceso
     */
    private function deleteAssociatedDocument(Proceso $proceso)
    {
        if ($proceso->documento && Storage::disk('public')->exists($proceso->documento)) {
            Storage::disk('public')->delete($proceso->documento);
        }
    }

    /**
     * Remover campos auxiliares de la validación
     */
    private function removeAuxiliaryFields(array &$validated)
    {
        unset($validated['eliminar_documento']);
    }
}

