<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoJuridico extends Model
{
    // 👇 Nombre real de la tabla en la BD
    //protected $table = 'conceptos';

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
