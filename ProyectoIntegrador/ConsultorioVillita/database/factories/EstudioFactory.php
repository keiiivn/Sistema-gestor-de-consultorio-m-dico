<?php

namespace Database\Factories;

use App\Models\Estudio;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Estudio>
 */
class EstudioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_paciente' => Paciente::factory(),
            'id_consulta' => null,
            'nombre_archivo' => fake()->word().'.pdf',
            'ruta_archivo' => 'estudios/demo.pdf',
            'tipo' => fake()->randomElement(['Laboratorio', 'Rayos X', 'Ultrasonido', 'Receta']),
            'descripcion' => fake()->optional()->sentence(8),
        ];
    }
}
