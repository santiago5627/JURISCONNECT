<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    use HasFactory;

    protected $table = 'lawyers';

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

    public $timestamps = true;

    public function assistants()
    {
        return $this->belongsToMany(
            Assistant::class,
            'assistant_lawyer',
            'lawyer_id',
            'assistant_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
