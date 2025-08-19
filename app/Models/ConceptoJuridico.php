<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoJuridico extends Model
{
    protected $fillable = ['proceso_id', 'abogado_id', 'concepto'];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }

    public function abogado()
    {
        return $this->belongsTo(User::class, 'abogado_id');
    }
}