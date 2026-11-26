<?php

namespace Database\Factories;

use App\Models\Receta;
use App\Models\RecetaMedicamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecetaMedicamento>
 */
class RecetaMedicamentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_receta' => Receta::factory(),
            'medicamento' => fake()->randomElement([
                'Paracetamol',
                'Ibuprofeno',
                'Amoxicilina',
                'Omeprazol',
                'Loratadina',
            ]),
            'presentacion' => fake()->randomElement(['Tabletas 500 mg', 'Jarabe 120 ml', 'Cápsulas 20 mg']),
            'dosis' => fake()->randomElement(['1 tableta', '5 ml', '1 cápsula']),
            'frecuencia' => fake()->randomElement(['Cada 8 horas', 'Cada 12 horas', 'Cada 24 horas']),
            'duracion' => fake()->randomElement(['3 días', '5 días', '7 días']),
            'via_administracion' => fake()->randomElement(['Oral', 'Tópica', 'Intramuscular']),
            'indicaciones' => fake()->optional()->sentence(10),
        ];
    }
}
