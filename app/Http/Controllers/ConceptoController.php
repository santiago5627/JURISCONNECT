<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proceso;
use App\Models\ConceptoJuridico;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ConceptoController extends Controller
{
    // ===============================
    // MÉTODOS PRINCIPALES
    // ===============================

    /**
     * Mostrar todos los procesos disponibles para crear conceptos
     */
    public function index()
    {
        $procesos = Proceso::where('abogado_id', auth())
                        ->where('estado', 'asignado')
                        ->whereDoesntHave('conceptos')
                        ->get();
        
        return view('legal_processes.listaProcesos', compact('procesos'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create() 
    {
        $procesos = Proceso::all();
        return view('legal_processes.createConceptos', compact('procesos'));
    }

    /**
     * Guardar el concepto para un proceso específico
     */
    public function store(Request $request, $procesoId)
    {
        $this->validateConceptoData($request);

        $proceso = Proceso::findOrFail($procesoId);
        
        $this->createConceptoForProceso($request, $proceso);
        $this->updateProcesoEstado($proceso);

        return redirect()->route('abogado.dashboard')
                        ->with('success', 'Concepto jurídico creado exitosamente.');
    }

    /**
     * Mostrar el formulario para crear un concepto para un proceso específico
     */
    public function verFormulario($procesoId)
    {
        $proceso = $this->getProcesoWithRelations($procesoId);
        
        $this->checkExistingConcepto($procesoId);
        
        return view('legal_processes.createConceptos', compact('proceso'));
    }

    // ===============================
    // MÉTODOS PRIVADOS DE APOYO
    // ===============================

    /**
     * Validar datos del concepto
     */
    private function validateConceptoData(Request $request)
    {
        $request->validate([
            'concepto' => 'required|min:50',
            'recomendaciones' => 'nullable|string'
        ]);
    }

    /**
     * Obtener proceso con sus relaciones
     */
    private function getProcesoWithRelations($procesoId)
    {
        return Proceso::with(['cliente', 'abogado'])->findOrFail($procesoId);
    }

    /**
     * Verificar si ya existe un concepto para el proceso
     */
    private function checkExistingConcepto($procesoId)
    {
        $conceptoExistente = ConceptoJuridico::where('proceso_id', $procesoId)->first();
        
        if ($conceptoExistente) {
            abort(redirect()->back()->with('error', 'Ya existe un concepto para este proceso.'));
        }
    }

    /**
     * Crear concepto jurídico para el proceso
     */
    private function createConceptoForProceso(Request $request, Proceso $proceso)
    {
        $concepto = new ConceptoJuridico();
        $concepto->proceso_id = $proceso->id;
        $concepto->abogado_id = auth();
        $concepto->concepto = $request->concepto;
        $concepto->recomendaciones = $request->recomendaciones;
        $concepto->estado = 'finalizado';
        $concepto->save();
    }

    /**
     * Actualizar estado del proceso
     */
    private function updateProcesoEstado(Proceso $proceso)
    {
        $proceso->update(['estado' => 'con_concepto']);
    }
}