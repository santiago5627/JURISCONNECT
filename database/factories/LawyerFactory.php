<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Lawyer;

class LawyerFactory extends Factory
{
    public function definition(): array
    {
        $tipos_documento = ['CC', 'CE', 'TI', 'NIT'];
        $especialidades = ['Civil', 'Laboral', 'Penal', 'Familia', 'Comercial'];

        return [
            'nombre'           => $this->faker->firstName(),
            'apellido'         => $this->faker->lastName(),
            'tipo_documento'   => $this->faker->randomElement($tipos_documento),
            'numero_documento' => $this->faker->unique()->numerify('##########'),
            'correo'           => $this->faker->unique()->safeEmail(),
            'telefono'         => $this->faker->phoneNumber(),
            'especialidad'     => $this->faker->randomElement($especialidades),
            'user_id'          => User::factory(), // Asocia un usuario creado con la fábrica de User
        ];
    }
}