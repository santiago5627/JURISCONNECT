<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.

     *
     * @var array<int, string>
     */
     
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // ¡Importante!
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**

     * Relación: Un usuario pertenece a un rol
     * Get the full URL for the user's avatar.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        return null; // o una imagen por defecto
    }
     /* Relación: Un usuario pertenece a un rol

     */

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Métodos útiles para verificar roles
     */
    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isLawyer(): bool
    {
        return $this->role && $this->role->name === 'lawyer';
    }

    public function isClient(): bool
    {
        return $this->role && $this->role->name === 'client';
    }

    /**
     * Obtener el nombre del rol
     */
    public function getRoleName(): string
    {
        return $this->role ? $this->role->name : 'Sin rol';
    }
}