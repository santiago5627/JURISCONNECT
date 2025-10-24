<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\ConceptoJuridico;

class ProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // Crea 20 registros falsos
        Proceso::factory()->count(10)->create();
    }
}
