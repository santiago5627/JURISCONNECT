<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use Illuminate\Support\Facades\Storage;

class LegalProcessController extends Controller
{
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
        // Validar datos de entrada
        $validated = $request->validate([
            'tipo_proceso'      => 'required|string|max:100',
            'numero_radicado'   => 'required|string|max:50|unique:procesos,numero_radicado',
            'demandante'        => 'required|string|max:255',
            'demandado'         => 'required|string|max:255',
            'descripcion'       => 'required|string',
            'documento'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Subir documento si existe
        if ($request->hasFile('documento')) {
            $validated['documento'] = $request->file('documento')->store('documentos', 'public');
        }

        // Crear proceso en la base de datos
        Proceso::create($validated);

        return redirect()
            ->route('procesos.index')
            ->with('success', ' Proceso judicial creado con éxito.');
    }

    /**
     * Listar procesos judiciales
     */
    public function index()
    {
        $procesos = Proceso::latest()->paginate(10);//10 por pagina
        return view('legal_processes.index', compact('procesos'));
    }

    /**
     * Mostrar un proceso específico
     */
    public function show($id)
    {
        $proceso = Proceso::findOrFail($id);
        return view('legal_processes.show', compact('proceso'));
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

        // Validar datos de entrada (excluyendo el número radicado actual)
        $validated = $request->validate([
            'tipo_proceso'      => 'required|string|max:100',
            'numero_radicado'   => 'required|string|max:50|unique:procesos,numero_radicado,' . $id,
            'demandante'        => 'required|string|max:255',
            'demandado'         => 'required|string|max:255',
            'descripcion'       => 'required|string',
            'documento'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'eliminar_documento' => 'nullable|boolean', // Para eliminar documento existente
        ]);

        // Manejar documento
        if ($request->hasFile('documento')) {
            // Eliminar documento anterior si existe
            if ($proceso->documento && Storage::disk('public')->exists($proceso->documento)) {
                Storage::disk('public')->delete($proceso->documento);
            }
            
            // Subir nuevo documento
            $validated['documento'] = $request->file('documento')->store('documentos', 'public');
        } elseif ($request->has('eliminar_documento') && $request->eliminar_documento) {
            // Eliminar documento si se marcó la opción
            if ($proceso->documento && Storage::disk('public')->exists($proceso->documento)) {
                Storage::disk('public')->delete($proceso->documento);
            }
            $validated['documento'] = null;
        } else {
            // Mantener documento actual
            unset($validated['documento']);
        }

        // Remover campo auxiliar de validación
        unset($validated['eliminar_documento']);

        // Actualizar proceso
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

        // Eliminar documento asociado si existe
        if ($proceso->documento && Storage::disk('public')->exists($proceso->documento)) {
            Storage::disk('public')->delete($proceso->documento);
        }

        $proceso->delete();

        return redirect()
            ->route('procesos.index')
            ->with('success', ' Proceso eliminado correctamente.');
    }

}
