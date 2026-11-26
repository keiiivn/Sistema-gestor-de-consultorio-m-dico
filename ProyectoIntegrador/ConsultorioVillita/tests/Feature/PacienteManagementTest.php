<?php

namespace Tests\Feature;

use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacienteManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_invitado_no_puede_acceder_al_listado_de_pacientes(): void
    {
        $this->get(route('panel.pacientes.index'))
            ->assertRedirect(route('login'));
    }

    public function test_un_administrador_puede_registrar_un_paciente(): void
    {
        $admin = Usuario::factory()->admin()->create();
        $medico = Medico::factory()->create();

        $this->actingAs($admin)
            ->post(route('panel.pacientes.store'), [
                'nombre' => 'María Fernanda López',
                'fecha_nacimiento' => '1992-04-15',
                'sexo' => 'F',
                'telefono' => '5511112222',
                'email' => 'maria@example.com',
                'id_medico' => $medico->id_medico,
                'activo' => '1',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('pacientes', [
            'nombre' => 'María Fernanda López',
            'sexo' => 'F',
            'id_medico' => $medico->id_medico,
        ]);
    }

    public function test_un_paciente_requiere_datos_validos(): void
    {
        $admin = Usuario::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('panel.pacientes.create'))
            ->post(route('panel.pacientes.store'), [
                'nombre' => '',
                'fecha_nacimiento' => now()->addDay()->format('Y-m-d'),
                'sexo' => 'X',
            ])
            ->assertRedirect(route('panel.pacientes.create'))
            ->assertSessionHasErrors(['nombre', 'fecha_nacimiento', 'sexo']);

        $this->assertDatabaseCount('pacientes', 0);
    }

    public function test_un_recepcionista_no_puede_administrar_usuarios(): void
    {
        $recepcionista = Usuario::factory()->recepcionista()->create();

        $this->actingAs($recepcionista)
            ->get(route('panel.usuarios.index'))
            ->assertForbidden();
    }

    public function test_un_medico_puede_registrar_una_consulta(): void
    {
        $medico = Medico::factory()->create();
        $paciente = Paciente::factory()->create([
            'id_medico' => $medico->id_medico,
        ]);

        $this->actingAs($medico->usuario)
            ->post(route('panel.consultas.store'), [
                'id_paciente' => $paciente->id_paciente,
                'id_medico' => $medico->id_medico,
                'fecha' => now()->format('Y-m-d\TH:i'),
                'motivo' => 'Dolor de cabeza',
                'diagnostico' => 'Cefalea tensional',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('consultas', [
            'id_paciente' => $paciente->id_paciente,
            'motivo' => 'Dolor de cabeza',
        ]);
    }
}
