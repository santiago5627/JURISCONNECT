<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LawyerController extends Controller
{
    /**
     * Muestra la lista de abogados con paginación y filtro.
     */
    public function index(Request $request)
    {
        // Inicia la consulta base sobre el modelo Lawyer.
        $query = Lawyer::query();

        // Aplica el filtro de búsqueda si el parámetro 'search' existe en la URL.
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            
            // Agrupa las condiciones 'OR' para que no interfieran con otras cláusulas 'WHERE' futuras.
            $query->where(function ($q) use ($searchTerm) {
                    $q->where('nombre', 'like', "%{$searchTerm}%")
                    ->orWhere('apellido', 'like', "%{$searchTerm}%")
                    ->orWhere('numero_documento', 'like', "%{$searchTerm}%")
                    ->orWhere('correo', 'like', "%{$searchTerm}%")
                    ->orWhere('especialidad', 'like', "%{$searchTerm}%")
                    ->orWhere('telefono', 'like', "%{$searchTerm}%");

                });
            }

        // --- PUNTO CLAVE 1: Contador General ---
        // Calcula el número total de abogados que coinciden con el filtro ANTES de paginar.
        // Este es el contador total, no el de la página actual.
        $total_lawyers = Lawyer::count();
        $filtered_lawyers = $query->count();      
        
        
        // --- PUNTO CLAVE 2: Paginación Persistente ---
        // Pagina los resultados y se asegura de que los parámetros de la URL (como 'search')
        // se mantengan en los enlaces de paginación.
        $lawyers = $query->latest()->paginate(10)->withQueryString();
        
        // Si la petición es vía AJAX (ej: desde un script de búsqueda en vivo),
        // devuelve solo la vista parcial de la tabla para no recargar la página completa.
        if ($request->ajax()) {
            return view('partials.lawyers-table', compact('lawyers', 'total_lawyers'))->render();
        }

        // Para la carga inicial de la página, devuelve la vista completa del dashboard.
        // Aquí puedes agregar la lógica real para estos contadores.
        $cases_count = 0; 
        $completed_cases = 0; 

        return view('dashboard', compact('lawyers', 'cases_count', 'completed_cases', 'total_lawyers'));
    }

    /**
     * Almacena un nuevo abogado en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipoDocumento' => 'required|string|in:CC,CE,PAS',
            'numeroDocumento' => 'required|string|max:20|unique:lawyers,numero_documento',
            'correo' => 'required|email|unique:lawyers,correo',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:255',
        ]);

        $lawyer = Lawyer::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'tipo_documento' => $validated['tipoDocumento'],
            'numero_documento' => $validated['numeroDocumento'],
            'correo' => $validated['correo'],
            'telefono' => $validated['telefono'],
            'especialidad' => $validated['especialidad'],
        ]);

        // Si es una petición AJAX, devuelve una respuesta JSON.
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Abogado creado exitosamente.',
                'lawyer' => $lawyer,
                'total_lawyers' => Lawyer::count() // Recalcula el total global.
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Abogado creado exitosamente.');
    }

    /**
     * Actualiza un abogado existente.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipoDocumento' => 'required|string|in:CC,CE,PAS',
            // Asegura que el numeroDocumento sea único, ignorando el del abogado actual.
            'numeroDocumento' => 'required|string|max:20|unique:lawyers,numero_documento,' . $lawyer->id,
            'correo' => 'required|email|unique:lawyers,correo,' . $lawyer->id,
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:255',
        ]);

        $lawyer->update([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'tipo_documento' => $validated['tipoDocumento'],
            'numero_documento' => $validated['numeroDocumento'],
            'correo' => $validated['correo'],
            'telefono' => $validated['telefono'],
            'especialidad' => $validated['especialidad'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Abogado actualizado exitosamente.',
                'lawyer' => $lawyer
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Abogado actualizado exitosamente.');
    }

    /**
     * Elimina un abogado.
     */
    public function destroy(Request $request, Lawyer $lawyer)
    {
        $lawyer->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Abogado eliminado exitosamente.',
                'total_lawyers' => Lawyer::count() // Recalcula el total global.
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Abogado eliminado exitosamente.');
    }
}