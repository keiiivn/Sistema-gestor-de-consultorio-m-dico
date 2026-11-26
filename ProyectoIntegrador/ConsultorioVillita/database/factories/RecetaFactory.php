<?php

namespace Database\Factories;

use App\Models\Consulta;
use App\Models\Receta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Receta>
 */
class RecetaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_consulta' => Consulta::factory(),
            'nombre_paciente' => fake()->name(),
            'edad' => fake()->numberBetween(18, 80),
            'altura' => fake()->randomFloat(2, 1.45, 1.95),
            'peso' => fake()->randomFloat(2, 50, 100),
            'indicaciones' => fake()->sentence(16),
        ];
    }
}
