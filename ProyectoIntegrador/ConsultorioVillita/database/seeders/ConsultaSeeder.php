<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class ConsultaSeeder extends Seeder
{
    public function run(): void
    {
        $citasAtendidas = Cita::where('estado', 'atendida')
            ->with('paciente')
            ->get();

        foreach ($citasAtendidas as $cita) {
            Consulta::factory()->create([
                'id_paciente' => $cita->id_paciente,
                'id_medico' => $cita->id_medico,
                'id_cita' => $cita->id_cita,
                'fecha' => $cita->fecha,
            ]);
        }

        $pacientes = Paciente::with('medico')->inRandomOrder()->take(8)->get();

        foreach ($pacientes as $paciente) {
            Consulta::factory()->create([
                'id_paciente' => $paciente->id_paciente,
                'id_medico' => $paciente->id_medico,
                'id_cita' => null,
            ]);
        }

        foreach (Consulta::all() as $consulta) {
            $paciente = $consulta->paciente;

            if (! $paciente) {
                continue;
            }

            if (! $paciente->ultima_consulta || $consulta->fecha->greaterThan($paciente->ultima_consulta)) {
                $paciente->update(['ultima_consulta' => $consulta->fecha]);
            }
        }
    }
}
