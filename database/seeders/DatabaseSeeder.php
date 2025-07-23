<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    public function run(): void
    {
        // Crear rol de administrador
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);

        // Crear un usuario con ese rol
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@sena.edu.co',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Puedes cambiar la clave
            'remember_token' => Str::random(10),
            'role_id' => $adminRole->id,
        ]);
    }
}
