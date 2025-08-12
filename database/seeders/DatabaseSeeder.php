<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    // Modifica tu DatabaseSeeder.php así:
public function run(): void
{
    // Crear rol de administrador sin el campo slug
    $adminRole = Role::firstOrCreate([
        'name' => 'Administrador'
    ]);

    // Crear un usuario con ese rol
    User::firstOrCreate([
        'email' => 'admin@sena.edu.co'
    ], [
        'name' => 'Admin',
        'password' => Hash::make('admin123'), // Cambia la contraseña según tus necesidades
        'role_id' => $adminRole->id,
        'remember_token' => Str::random(10),
    ]);
}
}
