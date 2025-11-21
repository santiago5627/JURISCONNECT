<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Lawyer;

class ProcesoFactory extends Factory
{
    public function definition(): array
    {
        $estados = ['Radicado','Pendiente', 'Primera instancia', 'En curso', 'Finalizado','En audiencia',
    'Pendiente fallo', 'Favorable primera', 'Desfavorable primera', 'En apelacion', 'Conciliacion pendiente', 'Conciliado',
    'Sentencia ejecutoriada', 'En proceso pago', 'Terminado']; 
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
