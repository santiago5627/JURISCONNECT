<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AbogadoUserSeeder extends Seeder   // 👈 Aquí debe llamarse AbogadoUserSeeder, no ProcesoSeeder

class AbogadoUserSeeder extends Seeder
{
    public function run(): void
    {
        Proceso::create([
    'nombre' => 'Proceso de prueba',
    'descripcion' => 'Proceso asignado al abogado inicial',
    ]);

        // Buscar el rol abogado
        $lawyerRole = Role::where('name', 'lawyer')->first();

        if (!$lawyerRole) {
            $this->command->error('No se encontró el rol abogado. Asegúrate de ejecutar RoleSeeder primero.');
            return;
        }

        // Crear usuario abogado
        $lawyer = User::firstOrCreate([
            'email' => 'abogado@example.com'
        ], [
            'name' => 'Abogado Ejemplo',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'role_id' => $lawyerRole->id,
        ]);

        $this->command->info('Usuario abogado creado:');
        $this->command->info('Email: abogado@example.com');
        $this->command->info('Contraseña: 123456');
    }
}
