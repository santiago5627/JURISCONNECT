<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_perfil',
        'password_changed',
        'avatar',
        'role_id',
        'profile_photos',
    ];

    // Accesor para la ruta de la foto de perfil
    public function getProfilePhotoPathAttribute()
    {
        return $this->foto_perfil ? asset('storage/' . $this->foto_perfil) : null;
    }

    // Atributos ocultos para la serialización
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts correctamente definidos
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación con Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}