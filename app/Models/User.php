<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; 

    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_perfil',
        'password_changed',
        'avatar',          // Campo para avatar
        'role_id',         // Rol del usuario
        'profile_photos'   
    ];
    public function getProfilePhotoPathAttribute()
        {
            return $this->foto_perfil ? asset('storage/' . $this->foto_perfil) : null;
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
    public function role()
{
    return $this->belongsTo(Role::class, 'role_id');
}

}