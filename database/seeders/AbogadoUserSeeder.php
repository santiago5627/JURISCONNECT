<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proceso;

class ProcesoSeeder extends Seeder
{
    public function run()
    {
        Proceso::create([
            'nombre' => 'Proceso de prueba 1',
            'descripcion' => 'Este es un proceso de ejemplo.',
            'estado' => 'En curso',
        ]);

        Proceso::create([
            'nombre' => 'Proceso de prueba 2',
            'descripcion' => 'Otro proceso de ejemplo.',
            'estado' => 'Finalizado',
        ]);
    }
}
