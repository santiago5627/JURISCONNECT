<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    
public function run(): void
{
    // Crear rol de administrador sin el campo slug
    $adminRole = Role::firstOrCreate([
        'name' => 'Administrador'
    ]);
    
    $this->call([
        ProcesoSeeder::class,
        AbogadoUserSeeder::class,
    ]);

    // Crear un usuario con ese rol
    User::firstOrCreate([
        'email' => 'brendaModa45@gmail.com'
    ], [
        'name' => 'Admin',
        'password' => Hash::make('admin123'), 
        'role_id' => $adminRole->id,
        'remember_token' => Str::random(10),
    ]);
}
}