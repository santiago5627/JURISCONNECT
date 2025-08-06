<?php

namespace App\Exports;

use App\Models\Lawyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class LawyersExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithDrawings, WithEvents
{
    public function collection()
    {
        return Lawyer::select('id', 'nombre', 'apellido', 'correo', 'telefono', 'especialidad')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Apellido', 'Correo Electrónico', 'Teléfono', 'Especialidad'];
    }

    public function title(): string
    {
        return 'Lista de Abogados';
    }

    public function styles(Worksheet $sheet)
    {
        // Fila 2: Título centrado
        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'Lista de Abogados');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Fila 3: Encabezado
        $sheet->getStyle('A3:F3')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3BB54A'],
            ],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Autoajustar columnas
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Aumentar la altura de la fila del logo
        $sheet->getRowDimension(1)->setRowHeight(60);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo SENA');
        $drawing->setDescription('Logo del SENA');
        $drawing->setPath(public_path('img/LogoInsti.png'));
        $drawing->setHeight(55);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);

        return [$drawing];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $dataRowStart = 4; // Datos desde fila 4
                $dataRowEnd = $dataRowStart + Lawyer::count() - 1;

                // Bordes a toda la tabla (desde A3:F{última fila})
                $event->sheet->getStyle("A3:F{$dataRowEnd}")->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                    'alignment' => ['vertical' => 'center'],
                ]);
            },
        ];
    }
}
