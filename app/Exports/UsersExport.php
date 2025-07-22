<?php

namespace App\Exports;

use App\Models\Lawyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, withStyles
{
    public function collection()
    {
        return Lawyer::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'nombre',
            'apellido',
            'tipo de documento',
            'numero de documento',
            'Correo Electrónico',
            'Fecha de Creación',
            'Fecha de Actualización',
            'telefono',
            'especialidad'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo para la primera fila (encabezados)
        
        $sheet->getStyle('A1:K1')->getFill()->setFillType('solid')->getStartColor()->setARGB('#5BEB42');
    }
}