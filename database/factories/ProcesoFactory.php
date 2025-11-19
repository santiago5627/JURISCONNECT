<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Lawyer;

class ProcesoFactory extends Factory
{
    public function definition(): array
    {
        $estados = ['radicado','Pendiente', 'primera_instancia', 'En curso', 'Finalizado','en_audiencia',
    'pendiente_fallo', 'favorable_primera', 'desfavorable_primera', 'en_apelacion', 'conciliacion_pendiente', 'conciliado',
    'sentencia_ejecutoriada', 'en_proceso_pago', 'terminado']; 
        $tipos = ['Civil', 'Laboral', 'Penal', 'Familia', 'Comercial'];

        return [
            'tipo_proceso'   => $this->faker->randomElement($tipos),
            'numero_radicado'=> $this->faker->unique()->numerify('RAD-########'),
            'demandante'     => $this->faker->name(),
            'demandado'      => $this->faker->name(),
            'descripcion'    => $this->faker->sentence(12),
            'estado'         => $this->faker->randomElement($estados),         
        ];
    }
}
