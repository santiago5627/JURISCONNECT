<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proceso;

class ProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proceso::create([
            'nombre' => 'Demanda Civil',
            'descripcion' => 'Proceso relacionado con disputas civiles.',
        ]);

        Proceso::create([
            'nombre' => 'Proceso Penal',
            'descripcion' => 'Caso relacionado con derecho penal.',
        ]);

        Proceso::create([
            'nombre' => 'Audiencia Laboral',
            'descripcion' => 'Conflictos laborales y sindicales.',
        ]);
    }
}
