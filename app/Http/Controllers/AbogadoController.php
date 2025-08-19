<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoJuridico; // Asegúrate de importar tu modelo
use Illuminate\Support\Facades\Auth;

class AbogadoController extends Controller
{
    // Dashboard principal del abogado
    public function index()
    {
        return view('dashboard-abogado');
    }

    // Mostrar procesos asignados al abogado
    public function misProcesos()
    { 
        // Obtener procesos del abogado logueado
        $procesos = ConceptoJuridico::where('abogado_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('legal_processes.conceptos', compact('procesos'));
    }

    // Mostrar lista de procesos o concepto específico
    public function crearConcepto($id = null)
    {
        // Si no se pasa ID, mostrar lista de procesos pendientes
        if (!$id) {
            $procesos = ConceptoJuridico::where('abogado_id', Auth::id())
                ->where(function ($q) {
                $q->whereNull('concepto_juridico')
                ->orWhere('estado_concepto', 'pendiente');
                })
            ->orderBy('fecha_radicacion', 'asc')
            ->get();

            return view('legal_processes.createConceptos', compact('procesos'));
        }

        // Si se pasa ID, mostrar el concepto específico
        try {
            // Buscar el proceso por ID
            $proceso = ConceptoJuridico::findOrFail($id);

            // Verificar que el abogado tenga acceso a este proceso
            if ($proceso->abogado_id !== Auth::id()) {
                return redirect()->back()->with('error', 'No tienes acceso a este proceso');
            }

            // Retornar la vista con los datos del proceso
            return view('legal_processes.conceptos', compact('proceso'));

            } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Proceso no encontrado');
            }
    }

    // Guardar el concepto jurídico
    public function guardarConcepto(Request $request, $id)
    {
        $request->validate([
            'concepto' => 'required|string|min:50',
            'recomendaciones' => 'nullable|string',
        ]);

        try {
            $proceso = ConceptoJuridico::findOrFail($id);
            
            // Verificar acceso
            if ($proceso->abogado_id !== Auth::id()) {
                return redirect()->back()->with('error', 'No tienes acceso a este proceso');
            }

            // Actualizar el proceso con el concepto
            $proceso->update([
                'concepto_juridico' => $request->concepto,
                'recomendaciones' => $request->recomendaciones,
                'fecha_concepto' => now(),
                'estado_concepto' => 'completado'
            ]);

            return redirect()->route('abogado.mis-procesos')
                        ->with('success', 'Concepto jurídico guardado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar el concepto');
        }
    }

    // Mostrar lista de procesos pendientes de concepto
    public function procesosPendientes()
    {
        $procesos = ConceptoJuridico::where('abogado_id', Auth::id())
    ->where(function ($q) {
            $q ->whereNull('concepto_juridico')
            ->orWhere('estado_concepto', 'pendiente');
    })
    ->orderBy('fecha_radicacion', 'asc')
    ->get();

        
        return view('abogado.procesos-pendientes', compact('procesos'));
    }

    // Ver detalles de un proceso específico
    public function verProceso($id)
    {
        try {
            $proceso = ConceptoJuridico::findOrFail($id);
            
            // Verificar acceso
            if ($proceso->abogado_id !== Auth::id()) {
                return redirect()->back()->with('error', 'No tienes acceso a este proceso');
            }
            
            return view('abogado.detalle-proceso', compact('proceso'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Proceso no encontrado');
        }
    }
}