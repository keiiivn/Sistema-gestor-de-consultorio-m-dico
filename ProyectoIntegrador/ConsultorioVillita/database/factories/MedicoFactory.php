<?php

namespace Database\Factories;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Medico>
 */
class MedicoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_usuario' => Usuario::factory()->medico(),
            'cedula' => fake()->unique()->numerify('##########'),
            'especialidad' => fake()->randomElement([
                'Medicina general',
                'Pediatría',
                'Ginecología',
                'Dermatología',
                'Nutrición',
            ]),
            'telefono' => fake()->numerify('55########'),
            'consultorio' => fake()->randomElement(['1', '2', '3']),
            'biografia' => fake()->sentence(18),
            'activo' => true,
        ];
    }

    public function sinUsuario(): static
    {
        return $this->state(fn (array $attributes) => [
            'id_usuario' => null,
        ]);
    }
}
