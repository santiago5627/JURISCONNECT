<?php

namespace App\Http\Controllers;


use App\Models\Proceso;
use App\Models\Lawyer;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProcesosExport;

class ProcesoReportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(
            new ProcesosExport(Auth::user()),
            'procesos.xlsx'
        );
    }

    public function exportPdf()
    {
        $query = Proceso::query();

        // FILTRO ABOGADO
        if (Auth::user()->role_id == 2) {
            $lawyer = Lawyer::where('user_id', Auth::id())->first();
            if ($lawyer) {
                $query->where('lawyer_id', $lawyer->id);
            }
        }

        // FILTRO ASISTENTE
        if (Auth::user()->role_id == 3) {
            $assistant = Auth::user()->assistant;
            if ($assistant) {
                $lawyerIds = $assistant->lawyers()->pluck('lawyer_id');
                $query->whereIn('lawyer_id', $lawyerIds);
            }
        }

        $procesos = $query->orderBy('numero_radicado')->get();

        $pdf = Pdf::loadView('exports.procesos-pdf', compact('procesos'));

        return $pdf->download('procesos.pdf');
    }
}
