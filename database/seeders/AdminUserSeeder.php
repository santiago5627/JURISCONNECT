<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar el rol admin
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->command->error('No se encontró el rol admin. Asegúrate de ejecutar RoleSeeder primero.');
            return;
        }

        // Crear usuario administrador
        $admin = User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Administrador',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'role_id' => $adminRole->id,
        ]);

        $this->command->info('Usuario administrador creado:');
        $this->command->info('Email: admin@admin.com');
        $this->command->info('Contraseña: 123456');
    }
}