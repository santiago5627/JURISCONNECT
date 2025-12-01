<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $table = 'procesos';

    protected $attributes = [
        'estado' => 'pendiente', // Valor por defecto
    ];

    protected $fillable = [
        'tipo_proceso',
        'numero_radicado',
        'demandante',
        'demandado',
        'descripcion',
        'documento',
        'estado',
        'fecha_inicio',
        'fecha_fin',
        'user_id',
        'lawyer_id',
        'created_at',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'created_at' => 'datetime:d-m-Y',
    ];

    /**
     * Relación con el usuario que creó el proceso
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el abogado asignado
     */
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('estado', $status);
    }

    /**
     * Scope para buscar procesos
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('numero_radicado', 'like', "%{$term}%")
            ->orWhere('demandante', 'like', "%{$term}%")
            ->orWhere('demandado', 'like', "%{$term}%")
            ->orWhere('tipo_proceso', 'like', "%{$term}%");
        });
    }

    /**
     * Obtener la URL del documento
     */
    public function getDocumentoUrlAttribute()
    {
        return $this->documento ? asset('storage/' . $this->documento) : null;
    }

    /**
     * Relación: Un proceso tiene un concepto jurídico
     */
    public function concepto()
    {
        return $this->hasOne(ConceptoJuridico::class, 'proceso_id');
    }

    public function conceptos()
    {
        return $this->hasMany(ConceptoJuridico::class);
    }
}
