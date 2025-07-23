<?php

namespace App\Exports;

use App\Models\Lawyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection, WithHeadings, withStyles
{
    public function collection()// Exporta todos los abogados
    {
        return Lawyer::all();
    }

    public function headings(): array // Encabezados de las columnas
    {
        return [
            'ID',
            'telefono',
            'especialidad'
        ];
    }

    public function styles(Worksheet $sheet) 
    {

        $sheet->getStyle('A1:J1')->applyFromArray([// Estilos para las celdas y colores
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => 'solid',
            'startColor' => ['argb' => '5BEB42'],
        ],
    ]);

        $rowCount = $this->collection()->count() + 1; // +1 por el encabezado bordes
        $range = 'A1:J' . $rowCount;

        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        return [];
    }




}



