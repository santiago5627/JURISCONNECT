<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes; 

    use HasFactory, Notifiable;


    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'foto_perfil',
        'password_changed',
        'avatar',          // Campo para avatar
        'role_id',         // Rol del usuario
        'profile_photos'   // Foto de perfil (asegúrate que en la migración sea igual)
    ];
    public function getProfilePhotoPathAttribute()
        {
            return $this->profile_photo;
        }

    /**
     * Los atributos que deben estar ocultos para la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Obtener los atributos que deben ser convertidos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

