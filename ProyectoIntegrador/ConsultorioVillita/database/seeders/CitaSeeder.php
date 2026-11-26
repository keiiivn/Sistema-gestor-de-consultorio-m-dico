<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Paciente::with('medico')->get();

        if ($pacientes->isEmpty()) {
            return;
        }

        $horarios = ['09:00', '10:00', '11:30', '13:00', '16:00', '17:30'];
        $estadosHoy = ['confirmada', 'confirmada', 'pendiente', 'confirmada', 'atendida', 'pendiente'];

        foreach ($horarios as $indice => $hora) {
            $paciente = $pacientes->get($indice);

            Cita::factory()->create([
                'id_paciente' => $paciente->id_paciente,
                'id_medico' => $paciente->id_medico,
                'fecha' => today()->setTimeFromTimeString($hora),
                'estado' => $estadosHoy[$indice],
            ]);
        }

        foreach ($pacientes->take(10) as $indice => $paciente) {
            Cita::factory()->create([
                'id_paciente' => $paciente->id_paciente,
                'id_medico' => $paciente->id_medico,
                'fecha' => today()->addDays($indice + 1)->setTimeFromTimeString($horarios[$indice % count($horarios)]),
                'estado' => $indice % 3 === 0 ? 'pendiente' : 'confirmada',
            ]);
        }

        foreach ($pacientes->slice(10) as $indice => $paciente) {
            Cita::factory()->create([
                'id_paciente' => $paciente->id_paciente,
                'id_medico' => $paciente->id_medico,
                'fecha' => today()->subDays($indice + 1)->setTimeFromTimeString($horarios[$indice % count($horarios)]),
                'estado' => $indice % 4 === 0 ? 'cancelada' : 'atendida',
            ]);
        }
    }
}
