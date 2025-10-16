<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use App\Models\Lawyer;

class LegalProcessController extends Controller
{
    // ===============================
    // CRUD BÁSICO
    // ===============================

    /**
     * Listar procesos judiciales
     */
    public function index()
    {
        $procesos = Proceso::latest()->paginate(10);
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
        $validated = $this->validateProcesoData($request);
        
        $this->handleDocumentUpload($request, $validated);
        
        Proceso::create($validated);

        return redirect()
            ->route('mis.procesos')
            ->with('success', 'Proceso judicial creado con éxito.');
    }

    /**
     * Mostrar un proceso específico
     */
    public function show($id)
    {
        $lawyer = Lawyer::findOrFail($id);
        return view('lawyers.show', compact('lawyer'));
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
            ->route('mis.procesos')
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