<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Paciente>
 */
class PacienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'fecha_nacimiento' => fake()->dateTimeBetween('-80 years', '-1 year'),
            'sexo' => fake()->randomElement(['M', 'F']),
            'telefono' => fake()->numerify('55########'),
            'email' => fake()->safeEmail(),
            'direccion' => fake()->streetAddress(),
            'padecimiento' => fake()->randomElement([
                'Dolor de cabeza recurrente',
                'Control de presión arterial',
                'Dolor lumbar',
                'Control de peso',
                'Tos persistente',
                null,
            ]),
            'alergias' => fake()->randomElement(['Ninguna', 'Penicilina', 'Polen', 'Mariscos']),
            'antecedentes' => fake()->optional()->sentence(12),
            'ultima_consulta' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
            'id_medico' => null,
            'activo' => true,
        ];
    }

    public function sinMedico(): static
    {
        return $this->state(fn (array $attributes) => [
            'id_medico' => null,
        ]);
    }
}
