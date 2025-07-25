<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    /**
     * Solo incluir 'name' sin 'description'
     */
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    public function isLawyer(): bool
    {
        return $this->name === 'lawyer';
    }

    public function isClient(): bool
    {
        return $this->name === 'client';
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}