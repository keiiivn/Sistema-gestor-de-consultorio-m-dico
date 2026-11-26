<?php

namespace Tests\Feature;

use Database\Seeders\MedicoSeeder;
use Database\Seeders\UsuarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_publica_esta_disponible(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Consultorio Villita')
            ->assertSee('Cuidamos de ti y de tu familia');
    }

    public function test_el_acceso_al_panel_esta_en_la_pagina_publica(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('login'));
    }

    public function test_la_pagina_muestra_la_ubicacion_y_datos_generales(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Calle José Vasconcelos, Mz. 50, Lote 11, Col. Darío Martínez 2.ª Secc.')
            ->assertSee('Cercanía')
            ->assertDontSee('25+')
            ->assertDontSee('6k');
    }

    public function test_la_pagina_muestra_a_la_doctora_del_consultorio(): void
    {
        $this->seed([UsuarioSeeder::class, MedicoSeeder::class]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Dra. Leonor Méndez Valerio')
            ->assertSee('Medicina general');
    }
}
