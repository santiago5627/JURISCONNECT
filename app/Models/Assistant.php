<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'correo',
        'telefono',
        'especialidad',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lawyers()
    {
        return $this->belongsToMany(
            Lawyer::class,
            'assistant_lawyer',
            'assistant_id',
            'lawyer_id'
        );
    }
}
