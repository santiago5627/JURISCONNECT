<?php

namespace App\Exports;

use App\Models\Proceso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ProcesosExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithDrawings
{
    public function collection()
{
    $procesos = Proceso::select(
        'numero_radicado', 
        'tipo_proceso', 
        'demandante', 
        'demandado', 
        'estado', 
        'created_at'
    )->get();

    $data = [];
    $contador = 1;
    foreach ($procesos as $proceso) {
        $data[] = [
            'ID' => $contador++,
            'Radicado' => $proceso->numero_radicado,
            'Tipo' => $proceso->tipo_proceso,
            'Demandante' => $proceso->demandante,
            'Demandado' => $proceso->demandado,
            'Estado' => $proceso->estado,
            'Fecha' => $proceso->created_at,
        ];
    }

    return collect($data);
}

    
public function headings(): array
{
    return ['ID', 'Radicado', 'Tipo', 'Demandante', 'Demandado', 'Estado', 'Fecha'];
}

    public function title(): string
    {
        return 'Lista de Abogados';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '3BB54A'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin'],
            ],
        ]);

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('LogoSENA');
        $drawing->setDescription('Logo del SENA');
        $drawing->setPath(public_path('img/LogoInsti.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('G1');
        $drawing->setOffsetX(5);
        $drawing->setOffsetY(5);

        return [$drawing];
    }
    /**
     * Exportar listado a PDF
     */
    public function exportPDF()
    {
        try {
            $procesos = Proceso::orderBy('numero_radicado')->get();
            $logoPath = public_path('img/LogoInsti.png');

            $pdf = Pdf::loadView('exports.procesos-pdf', compact('procesos', 'logoPath'))
                ->setPaper('a4', 'portrait');

            return $pdf->download('listado_procesos_' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error al exportar PDF de procesos', ['message' => $e->getMessage()]);
            return back()->with('error', 'Error al generar el PDF');
        }
    }
}
