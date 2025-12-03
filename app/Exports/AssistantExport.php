<?php

namespace App\Exports;

use App\Models\Assistant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class AssistantExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithDrawings
{
    public function collection()
    {
        $assistants = Assistant::select('id', 'nombre', 'apellido', 'correo', 'telefono')->get();

        $data = [];
        $contador = 1;
        foreach ($assistants as $assistant) {
            $data[] = [
                'id' => $contador++,
                'nombre' => $assistant->nombre,
                'apellido' => $assistant->apellido,
                'correo' => $assistant->correo,
                'teléfono' => $assistant->telefono,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return ['id', 'nombre', 'apellido', 'correo', 'teléfono'];
    }

    public function title(): string
    {
        return 'Lista de asistentes';
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
            $assistants = Assistant::orderBy('nombre')->get();
            $logoPath = public_path('img/LogoInsti.png');

            $pdf = Pdf::loadView('exports.asistente-pdf', compact('assistants', 'logoPath'))
                ->setPaper('a4', 'portrait');

            return $pdf->download('listado_asistentes' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error al exportar PDF de abogados', [
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al generar el PDF');
        }
    }
}
