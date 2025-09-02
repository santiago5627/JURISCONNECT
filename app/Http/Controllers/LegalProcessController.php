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
            ->with('success', 'Proceso judicial creado con éxito.');
    }

    /**
     * Listar procesos judiciales
     */
    public function index()
    {
        $procesos = Proceso::latest()->paginate(10);
        return view('legal_processes.index', compact('procesos'));
    }

    /**
     * Mostrar un proceso específico
     */
    public function show($id)
    {
        $proceso = Proceso::findOrFail($id);
        return view('procesos.show', compact('proceso'));
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

    public function edit($id)
{
    $proceso = Proceso::findOrFail($id);
    return view('procesos.edit', compact('proceso'));
}

public function update(Request $request, $id)
{
    $proceso = Proceso::findOrFail($id);

    $validated = $request->validate([
        'tipo_proceso'    => 'required|string|max:100',
        'numero_radicado' => 'required|string|max:50|unique:procesos,numero_radicado,'.$id,
        'demandante'      => 'required|string|max:255',
        'demandado'       => 'required|string|max:255',
        'descripcion'     => 'required|string',
        'documento'       => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    if ($request->hasFile('documento')) {
        $validated['documento'] = $request->file('documento')->store('documentos', 'public');
    }

    $proceso->update($validated);

    return redirect()->route('procesos.index')->with('success', 'Proceso actualizado correctamente.');
}


}
