<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoJuridico;
use Illuminate\Support\Facades\Auth;

class AbogadoController extends Controller
{
    // Dashboard principal del abogado
    public function index()
    {
        // Obtener estadísticas para el dashboard
        $estadisticas = $this->estadisticas();
        return view('dashboard-abogado', $estadisticas);
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
        // Obtener todos los procesos o los procesos del usuario autenticado
        $procesos = ConceptoJuridico::all();

        // Si no se pasa ID, mostrar lista de procesos pendientes
        if (!$id) {
            $procesos = ConceptoJuridico::where('abogado_id', Auth::id())
                ->where('estado', 'pendiente')
                ->orderBy('fecha_radicacion', 'asc')
                ->get();

            dd($procesos);

            return view('legal_processes.createConceptos', compact('procesos'));
        }

        // Si se pasa ID, mostrar el formulario para ese proceso específico
        try {
            $proceso = ConceptoJuridico::findOrFail($id);

            // Verificar que el abogado tenga acceso a este proceso
            if ($proceso->abogado_id !== Auth::id()) {
                return redirect()->route('abogado.crear-concepto')
                    ->with('error', 'No tienes acceso a este proceso');
            }

            // Verificar que el proceso esté pendiente
            if ($proceso->estado !== 'pendiente') {
                return redirect()->route('abogado.crear-concepto')
                    ->with('error', 'Este proceso ya no está pendiente de concepto');
            }

            return view('legal_processes.editarConcepto', compact('proceso'));

        } catch (\Exception $e) {
            return redirect()->route('abogado.crear-concepto')
                ->with('error', 'Proceso no encontrado');
        }
    }

    // Guardar el concepto jurídico
    public function guardarConcepto(Request $request, $id)
    {
        $request->validate([
            'concepto' => 'required|string|min:50',
            'recomendaciones' => 'nullable|string|max:2000',
        ], [
            'concepto.required' => 'El concepto jurídico es obligatorio',
            'concepto.min' => 'El concepto jurídico debe tener al menos 50 caracteres',
            'recomendaciones.max' => 'Las recomendaciones no pueden exceder 2000 caracteres'
        ]);

        try {
            $proceso = ConceptoJuridico::findOrFail($id);
            
            // Verificar acceso
            if ($proceso->abogado_id !== Auth::id()) {
                return redirect()->route('abogado.crear-concepto')
                    ->with('error', 'No tienes acceso a este proceso');
            }

            // Verificar que el proceso esté pendiente
            if ($proceso->estado !== 'pendiente') {
                return redirect()->route('abogado.crear-concepto')
                    ->with('error', 'Este proceso ya fue procesado anteriormente');
            }

            // Actualizar el proceso con el concepto
            $proceso->update([
                'estado' => 'en curso', // Cambiar a "en curso" después de agregar concepto
                'updated_at' => now()
            ]);

            // Aquí podrías crear un registro en una tabla separada para los conceptos
            // si decides implementar esa estructura más adelante

            return redirect()->route('abogado.crear-concepto')
                ->with('success', 'Concepto jurídico guardado exitosamente. El proceso ha sido marcado como "en curso".');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al guardar el concepto: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Mostrar lista de procesos pendientes de concepto
    public function procesosPendientes()
    {
        $procesos = ConceptoJuridico::where('abogado_id', Auth::id())
            ->where('estado', 'pendiente')
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

    // Método para obtener estadísticas del abogado
    public function estadisticas()
    {
        $totalProcesos = ConceptoJuridico::where('abogado_id', Auth::id())->count();
        $procesosPendientes = ConceptoJuridico::where('abogado_id', Auth::id())
            ->where('estado', 'pendiente')
            ->count();
        $procesosFinalizados = ConceptoJuridico::where('abogado_id', Auth::id())
            ->where('estado', 'finalizado')
            ->count();
        $procesosEnCurso = ConceptoJuridico::where('abogado_id', Auth::id())
            ->where('estado', 'en curso')
            ->count();

        return compact('totalProcesos', 'procesosPendientes', 'procesosFinalizados', 'procesosEnCurso');
    }

    // Finalizar proceso (cambiar estado a finalizado)
    public function finalizarProceso($id)
    {
        try {
            $proceso = ConceptoJuridico::findOrFail($id);
            
            // Verificar acceso
            if ($proceso->abogado_id !== Auth::id()) {
                return redirect()->back()->with('error', 'No tienes acceso a este proceso');
            }

            // Solo se puede finalizar procesos en curso
            if ($proceso->estado !== 'en curso') {
                return redirect()->back()->with('error', 'Solo se pueden finalizar procesos que estén en curso');
            }

            $proceso->update(['estado' => 'finalizado']);

            return redirect()->route('abogado.mis-procesos')
                ->with('success', 'Proceso finalizado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al finalizar el proceso');
        }
    }
}