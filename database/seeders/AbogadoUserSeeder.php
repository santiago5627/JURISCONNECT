<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proceso;

class AbogadoUserSeeder extends Seeder   // 👈 Aquí debe llamarse AbogadoUserSeeder, no ProcesoSeeder
{
    public function run()
    {
        Proceso::create([
    'nombre' => 'Proceso de prueba',
    'descripcion' => 'Proceso asignado al abogado inicial',
    ]);
    }
}
