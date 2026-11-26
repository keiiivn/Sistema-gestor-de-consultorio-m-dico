<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            MedicoSeeder::class,
            PacienteSeeder::class,
            CitaSeeder::class,
            ConsultaSeeder::class,
            RecetaSeeder::class,
            EstudioSeeder::class,
        ]);
    }
}
