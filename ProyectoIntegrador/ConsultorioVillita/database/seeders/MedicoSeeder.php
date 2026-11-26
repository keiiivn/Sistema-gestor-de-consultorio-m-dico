<?php

namespace Database\Seeders;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class MedicoSeeder extends Seeder
{
    public function run(): void
    {
        $medicos = [
            [
                'usuario' => 'dra.mendez',
                'cedula' => 'MEML900101MDF',
                'especialidad' => 'Medicina general',
                'consultorio' => '1',
                'telefono' => '5512345679',
                'biografia' => 'Médica general con enfoque en medicina preventiva y acompañamiento cercano a cada familia.',
            ],
        ];

        foreach ($medicos as $datos) {
            $usuario = Usuario::where('usuario', $datos['usuario'])->first();

            if (! $usuario) {
                continue;
            }

            Medico::updateOrCreate(
                ['cedula' => $datos['cedula']],
                [
                    'id_usuario' => $usuario->id_usuario,
                    'especialidad' => $datos['especialidad'],
                    'telefono' => $datos['telefono'],
                    'consultorio' => $datos['consultorio'],
                    'biografia' => $datos['biografia'],
                    'activo' => true,
                ]
            );
        }
    }
}
