<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoJuridico extends Model
{
    protected $fillable = [
        'numero_radicado',
        'tipo_proceso', 
        'demandante',
        'demandado',
        'fecha_radicacion',
        'estado',
        'abogado_id'
    ];
    
}
