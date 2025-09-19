<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class LawyerController extends Controller

{
    public function index(Request $request)
    {
        $query = Lawyer::query();
        
        // Aplicar filtro de búsqueda si existe
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre', 'like', '%' . $searchTerm . '%')
                ->orWhere('apellido', 'like', '%' . $searchTerm . '%')
                ->orWhere('numero_documento', 'like', '%' . $searchTerm . '%')
                ->orWhere('correo', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Paginación
        $lawyers = $query->paginate(10);
        
        // Mantener parámetros de búsqueda en la paginación
        if ($request->has('search')) {
            $lawyers->appends(['search' => $request->search]);
        }
        
        // Si es una petición AJAX, devolver solo el contenido necesario
        if ($request->ajax()) {
            return view('dashboard', compact('lawyers'))->render();
        }
        
        // Para peticiones normales, devolver la vista completa con datos adicionales
        $cases_count = 0; // Reemplazar con tu lógica real
        $completed_cases = 0; // Reemplazar con tu lógica real
        
        return view('dashboard', compact('lawyers', 'cases_count', 'completed_cases'));
    }
    
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
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Abogado creado exitosamente',
                'lawyer' => $lawyer
            ]);
        }
        
        return redirect()->route('dashboard')->with('success', 'Abogado creado exitosamente');
    }
    
    public function update(Request $request, Lawyer $lawyer)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipoDocumento' => 'required|string|in:CC,CE,PAS',
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
                'message' => 'Abogado actualizado exitosamente',
                'lawyer' => $lawyer
            ]);
        }
        
        return redirect()->route('dashboard')->with('success', 'Abogado actualizado exitosamente');
    }
    
    public function destroy(Request $request, Lawyer $lawyer)
    {
        $lawyer->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Abogado eliminado exitosamente'
            ]);
        }
        
        return redirect()->route('dashboard')->with('success', 'Abogado eliminado exitosamente');
    }
    
    public function exportExcel()
    {
        // Implementar lógica de exportación a Excel
        return response()->json([
            'message' => 'Funcionalidad de exportación a Excel en desarrollo'
        ]);
    }
    
    public function exportPdf()
    {
        // Implementar lógica de exportación a PDF
        return response()->json([
            'message' => 'Funcionalidad de exportación a PDF en desarrollo'
        ]);
    }
}