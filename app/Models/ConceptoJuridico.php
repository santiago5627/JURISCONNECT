<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoJuridico extends Model
{
    protected $fillable = [
        'titulo',
        'categoria',
        'descripcion',
        'abogado_id',
        'estado',
        'concepto',
        'recomendaciones',
        'fecha_radicacion',
        'created_at',
        'updated_at'
    ];

    // Relación con el abogado (usuario)
    public function abogado()
    {
        return $this->belongsTo(User::class, 'abogado_id');
    }
}