<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'nombre' => 'Administración Villita',
                'usuario' => 'admin',
                'email' => 'admin@consultoriovillita.mx',
                'password' => 'admin123',
                'rol' => 'admin',
                'telefono' => '5512345678',
            ],
            [
                'nombre' => 'Dra. Leonor Méndez Valerio',
                'usuario' => 'dra.mendez',
                'email' => 'leonor@consultoriovillita.mx',
                'password' => 'medico123',
                'rol' => 'medico',
                'telefono' => '5512345679',
            ],
            [
                'nombre' => 'Lucía Hernández',
                'usuario' => 'recepcion',
                'email' => 'recepcion@consultoriovillita.mx',
                'password' => 'recepcion123',
                'rol' => 'recepcionista',
                'telefono' => '5512345682',
            ],
        ];

        foreach ($usuarios as $usuario) {
            Usuario::updateOrCreate(
                ['usuario' => $usuario['usuario']],
                $usuario + ['activo' => true]
            );
        }
    }
}
