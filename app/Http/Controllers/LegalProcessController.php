<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use App\Models\Lawyer;
use Illuminate\Support\Facades\Auth;

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
        $query = \App\Models\Proceso::query();

    //Mostrar solo los procesos del abogado autenticado 
        $query->where('lawyer_id', Auth::id());


        // Búsqueda
        if ($request->has('search') && $request->get('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('numero_radicado', 'LIKE', '%' . $search . '%')
                  ->orWhere('demandante', 'LIKE', '%' . $search . '%')
                  ->orWhere('demandado', 'LIKE', '%' . $search . '%')
                  ->orWhere('tipo_proceso', 'LIKE', '%' . $search . '%')
                  ->orWhere('estado', 'LIKE', '%' . $search . '%');
            });
        }

        $procesos = $query->orderBy('id', 'asc')->paginate(10);

        // Respuesta AJAX: usar la vista correcta y devolver 'total'
        if ($request->ajax() || $request->get('ajax')) {
            // corregir la ruta de la vista y la variable que espera el partial
            $html = view('profile.partials.processes-table', ['procesos' => $procesos])->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $procesos->total()
            ]);
        }

        return view('legal_processes.index', compact('procesos'));
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
    try {

        $validated = $this->validateProcesoData($request);

        // Estado por defecto
        $validated['estado'] = 'Pendiente'; 

        // ASIGNAR EL ABOGADO QUE CREA EL PROCESO
        $validated['lawyer_id'] = Auth::user()->id;


        // Manejar documento
        $this->handleDocumentUpload($request, $validated);

        // Crear proceso
        $proceso = Proceso::create($validated);

        // Si es petición AJAX
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Proceso judicial creado con éxito.',
                'data' => $proceso
            ], 201);
        }

        // Redirección normal
        return redirect()
        ->route('abogado.dashboard')
        ->with('success', 'Proceso judicial creado con éxito.');


    } catch (\Illuminate\Validation\ValidationException $e) {

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }

        throw $e;

    } catch (\Exception $e) {

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el proceso',
                'error' => $e->getMessage()
            ], 500);
        }

        throw $e;
    }
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
            ->route('procesos.index', $proceso->id)
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
            ->route('mis.procesos')
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
            'estado'            => 'nullable|string',
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
            'estado'            => 'nullable|string',
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
