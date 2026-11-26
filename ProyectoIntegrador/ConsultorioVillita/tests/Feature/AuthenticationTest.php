<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pantalla_de_acceso_se_muestra(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Entra al panel');
    }

    public function test_un_usuario_puede_iniciar_sesion(): void
    {
        $usuario = Usuario::factory()->create([
            'usuario' => 'recepcion',
            'password' => 'secreto123',
            'activo' => true,
        ]);

        $respuesta = $this->post(route('login.store'), [
            'usuario' => 'recepcion',
            'password' => 'secreto123',
        ]);

        $respuesta->assertRedirect(route('panel.dashboard'));
        $this->assertAuthenticatedAs($usuario);
    }

    public function test_un_usuario_no_puede_iniciar_sesion_con_contrasena_incorrecta(): void
    {
        Usuario::factory()->create([
            'usuario' => 'recepcion',
            'password' => 'secreto123',
            'activo' => true,
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'usuario' => 'recepcion',
                'password' => 'incorrecta',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('usuario');

        $this->assertGuest();
    }

    public function test_un_usuario_inactivo_no_puede_iniciar_sesion(): void
    {
        Usuario::factory()->create([
            'usuario' => 'inactivo',
            'password' => 'secreto123',
            'activo' => false,
        ]);

        $this->post(route('login.store'), [
            'usuario' => 'inactivo',
            'password' => 'secreto123',
        ])->assertSessionHasErrors('usuario');

        $this->assertGuest();
    }

    public function test_un_invitado_es_redirigido_al_acceso(): void
    {
        $this->get(route('panel.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_un_usuario_puede_cerrar_sesion(): void
    {
        $usuario = Usuario::factory()->create();

        $this->actingAs($usuario)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
