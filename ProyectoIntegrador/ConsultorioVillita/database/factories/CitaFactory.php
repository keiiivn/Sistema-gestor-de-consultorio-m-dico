<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cita>
 */
class CitaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_paciente' => Paciente::factory(),
            'id_medico' => null,
            'fecha' => fake()->dateTimeBetween('now', '+30 days'),
            'duracion_minutos' => 30,
            'motivo' => fake()->randomElement([
                'Consulta general',
                'Revisión',
                'Seguimiento de tratamiento',
                'Entrega de resultados',
            ]),
            'estado' => 'pendiente',
            'observaciones' => null,
        ];
    }

    public function confirmada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'confirmada',
        ]);
    }

    public function atendida(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'atendida',
        ]);
    }

    public function cancelada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'cancelada',
        ]);
    }
}
