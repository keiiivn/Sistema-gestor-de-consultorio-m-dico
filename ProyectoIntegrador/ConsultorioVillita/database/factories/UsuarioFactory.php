<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        $nombre = fake()->name();

        return [
            'nombre' => $nombre,
            'usuario' => Str::slug($nombre, '.'),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'rol' => 'recepcionista',
            'telefono' => fake()->numerify('55########'),
            'activo' => true,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => 'admin',
            'usuario' => 'admin',
            'nombre' => 'Administrador Villita',
            'email' => 'admin@consultoriovillita.mx',
        ]);
    }

    public function medico(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => 'medico',
        ]);
    }

    public function recepcionista(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => 'recepcionista',
        ]);
    }
}
