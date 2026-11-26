<?php

namespace Database\Seeders;

use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $medicos = Medico::pluck('id_medico');

        if ($medicos->isEmpty()) {
            return;
        }

        Paciente::factory()
            ->count(18)
            ->create()
            ->each(function (Paciente $paciente) use ($medicos): void {
                $paciente->update([
                    'id_medico' => $medicos->random(),
                    'fecha_registro' => fake()->dateTimeBetween('-2 years', 'now'),
                ]);
            });
    }
}
