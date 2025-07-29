<?php

namespace App\Exports;

use App\Models\Lawyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LawyersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Lawyer::select('nombre', 'apellido', 'tipo_documento', 'numero_documento', 'correo', 'telefono', 'especialidad')->get();
    }

    public function headings(): array
    {
        return ['Nombre', 'Apellido', 'Tipo de Documento', 'Número de Documento', 'Correo', 'Teléfono', 'Especialidad'];
    }
}
