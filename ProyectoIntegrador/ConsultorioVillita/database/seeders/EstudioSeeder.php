<?php

namespace Database\Seeders;

use App\Models\Consulta;
use App\Models\Estudio;
use App\Models\Paciente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EstudioSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Paciente::take(5)->get();
        $tipos = ['Laboratorio', 'Rayos X', 'Ultrasonido', 'Receta'];

        foreach ($pacientes as $indice => $paciente) {
            $tipo = $tipos[$indice % count($tipos)];
            $nombreArchivo = 'estudio-'.$paciente->id_paciente.'.txt';
            $ruta = 'estudios/'.$nombreArchivo;

            Storage::disk('local')->put($ruta, "Estudio de ejemplo para {$paciente->nombre}.\nTipo: {$tipo}\n");

            $consulta = Consulta::where('id_paciente', $paciente->id_paciente)->first();

            Estudio::factory()->create([
                'id_paciente' => $paciente->id_paciente,
                'id_consulta' => $consulta?->id_consulta,
                'nombre_archivo' => $nombreArchivo,
                'ruta_archivo' => $ruta,
                'tipo' => $tipo,
                'descripcion' => 'Documento de ejemplo generado por el seeder.',
            ]);
        }
    }
}
