<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lawyer extends Model
{
    /*use SoftDeletes;*/
    //use SoftDeletes;
    use HasFactory;


    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'telefono',
        'correo',
        'especialidad',
        'user_id',
    ];

    // relación (si la tienes)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
