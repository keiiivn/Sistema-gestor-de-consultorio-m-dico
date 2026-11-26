<?php

namespace Database\Factories;

use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Consulta>
 */
class ConsultaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_paciente' => Paciente::factory(),
            'id_medico' => null,
            'id_cita' => null,
            'fecha' => fake()->dateTimeBetween('-6 months', 'now'),
            'motivo' => fake()->sentence(10),
            'antecedentes' => fake()->optional()->sentence(14),
            'signos_vitales' => 'TA 120/80 mmHg · FC 72 lpm · Temp 36.5 °C · Peso 68 kg · Talla 1.70 m',
            'revision_fisica' => fake()->sentence(18),
            'diagnostico' => fake()->randomElement([
                'Faringitis aguda',
                'Lumbalgia mecánica',
                'Gastritis leve',
                'Rinofaringitis viral',
                'Control metabólico',
            ]),
            'tratamiento' => fake()->sentence(14),
            'resultados' => null,
            'notas' => null,
        ];
    }
}
