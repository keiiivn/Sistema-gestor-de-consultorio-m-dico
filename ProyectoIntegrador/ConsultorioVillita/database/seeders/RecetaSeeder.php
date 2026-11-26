<?php

namespace Database\Seeders;

use App\Models\Consulta;
use App\Models\Receta;
use App\Models\RecetaMedicamento;
use Illuminate\Database\Seeder;

class RecetaSeeder extends Seeder
{
    public function run(): void
    {
        $consultas = Consulta::with('paciente')->take(12)->get();

        foreach ($consultas as $consulta) {
            $paciente = $consulta->paciente;

            $receta = Receta::factory()->create([
                'id_consulta' => $consulta->id_consulta,
                'nombre_paciente' => $paciente?->nombre,
                'edad' => $paciente?->edad,
                'indicaciones' => 'Tomar los medicamentos según lo indicado y acudir a revisión en caso de presentar molestias.',
            ]);

            RecetaMedicamento::factory()->count(2)->create([
                'id_receta' => $receta->id_receta,
            ]);
        }
    }
}
