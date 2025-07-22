<?php

namespace App\Exports;

use App\Models\Lawyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection, WithHeadings, withStyles, WithColumnWidths
{
    public function collection()// Exporta todos los abogados
    {
        return Lawyer::all();
    }

    public function headings(): array // Encabezados de las columnas
    {
        return [
            'ID',
            'nombre',
            'apellido',
            'tipo C.C',
            'N. C.C',
            'Correo Electrónico',
            'Fecha Creación',
            'Fecha Actualización',
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

    public function columnWidths(): array // Ancho de las columnas
    {
        return [
            'A' => 5, //  (ID)
            'B' => 10, // (Nombre)
            'C' => 10, // (Apellido)
            'D' => 8, // (Tipo de Documento)
            'E' => 10, // (Numero de Documento)
            'F' => 15, // (Correo Electrónico)
            'G' => 15, // (Fecha de Creación)
            'H' => 15, // (FEcha de Actualización)
            'I' => 10, // (Telefono)
            'J' => 15, // (Especialidad)
        ];
    }




}



