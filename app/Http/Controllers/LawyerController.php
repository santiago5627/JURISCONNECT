<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class LawyerController extends Controller
{
    /**
     * Muestra la lista de abogados con paginación y filtro.
     */
    public function index(Request $request)
    {
        $query = Lawyer::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', "%{$searchTerm}%")
                  ->orWhere('apellido', 'like', "%{$searchTerm}%")
                  ->orWhere('numero_documento', 'like', "%{$searchTerm}%")
                  ->orWhere('correo', 'like', "%{$searchTerm}%")
                  ->orWhere('telefono', 'like', "%{$searchTerm}%")
                  ->orWhere('especialidad', 'like', "%{$searchTerm}%");
            });
        }

        $total_lawyers = Lawyer::count();
        $filtered_lawyers = $query->count();      
        
        $lawyers = $query->latest()->paginate(10)->withQueryString();
        
        if ($request->ajax()) {
            return view('partials.lawyers-table', compact('lawyers', 'total_lawyers'))->render();
        }

        $cases_count = 0; 
        $completed_cases = 0; 

        return view('dashboard', compact('lawyers', 'cases_count', 'completed_cases', 'total_lawyers'));
    }

    /**
     * Almacena un nuevo abogado en la base de datos.
     * 
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'tipoDocumento'     => 'required|string|in:CC,CE,PAS',
            'numeroDocumento'   => 'required|string|max:20|unique:lawyers,numero_documento',
            'correo'            => 'required|email|unique:lawyers,correo',
            'telefono'          => 'required|string|max:20|unique:lawyers,telefono',
            'especialidad'      => 'nullable|string|max:255',
        ]);

        try {
            $lawyer = Lawyer::create([
                'nombre'            => $validated['nombre'],
                'apellido'          => $validated['apellido'],
                'tipo_documento'    => $validated['tipoDocumento'],
                'numero_documento'  => $validated['numeroDocumento'],
                'telefono'          => $validated['telefono'],
                'correo'            => $validated['correo'],
                'especialidad'      => $validated['especialidad'],
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado creado exitosamente.',
                    'lawyer' => $lawyer,
                    'total_lawyers' => Lawyer::count()
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Abogado creado exitosamente.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al registrar el abogado: ' . $e->getMessage()
                ], 400);
            }

            return redirect()->back()->withErrors('Error al registrar el abogado: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un abogado existente.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        $validated = $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'tipoDocumento'     => 'required|string|in:CC,CE,PAS',
            'numeroDocumento'   => 'required|string|max:20|unique:lawyers,numero_documento,' . $lawyer->id,
            'correo'            => 'required|email|unique:lawyers,correo,' . $lawyer->id,
            'telefono'          => 'required|string|max:20|unique:lawyers,telefono,' . $lawyer->id,
            'especialidad'      => 'nullable|string|max:255',
        ]);

        try {
            $lawyer->update([
                'nombre'            => $validated['nombre'],
                'apellido'          => $validated['apellido'],
                'tipo_documento'    => $validated['tipoDocumento'],
                'numero_documento'  => $validated['numeroDocumento'],
                'correo'            => $validated['correo'],
                'telefono'          => $validated['telefono'],
                'especialidad'      => $validated['especialidad'],
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado actualizado exitosamente.',
                    'lawyer' => $lawyer
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Abogado actualizado exitosamente.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el abogado: ' . $e->getMessage()
                ], 400);
            }

            return redirect()->back()->withErrors('Error al actualizar el abogado: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un abogado.
     */
    public function destroy(Request $request, Lawyer $lawyer)
    {
        try {
            $lawyer->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado eliminado exitosamente.',
                    'total_lawyers' => Lawyer::count()
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Abogado eliminado exitosamente.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el abogado: ' . $e->getMessage()
                ], 400);
            }

            return redirect()->back()->withErrors('Error al eliminar el abogado: ' . $e->getMessage());
        }
    }

    /**
     * Exporta los abogados a PDF.
     */
    public function exportPDF()
    {
        $lawyers = Lawyer::all();

        $logoPath = public_path('img/LogoInsti.png');

        $pdf = Pdf::loadView('lawyers.pdf', compact('lawyers', 'logoPath'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('abogados.pdf');
    }
}
