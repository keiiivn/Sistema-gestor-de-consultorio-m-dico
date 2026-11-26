<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Estudio;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Receta;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_las_pantallas_del_panel_se_muestran_para_un_administrador(): void
    {
        Storage::fake('local');

        $admin = Usuario::factory()->admin()->create();
        $medico = Medico::factory()->create();
        $paciente = Paciente::factory()->create(['id_medico' => $medico->id_medico]);
        $cita = Cita::factory()->create([
            'id_paciente' => $paciente->id_paciente,
            'id_medico' => $medico->id_medico,
        ]);
        $consulta = Consulta::factory()->create([
            'id_paciente' => $paciente->id_paciente,
            'id_medico' => $medico->id_medico,
            'id_cita' => $cita->id_cita,
        ]);
        $receta = Receta::factory()->create(['id_consulta' => $consulta->id_consulta]);
        $estudio = Estudio::factory()->create([
            'id_paciente' => $paciente->id_paciente,
            'id_consulta' => $consulta->id_consulta,
        ]);

        Storage::disk('local')->put($estudio->ruta_archivo, 'contenido');

        $rutas = [
            route('panel.dashboard'),
            route('panel.pacientes.index'),
            route('panel.pacientes.create'),
            route('panel.pacientes.show', $paciente),
            route('panel.pacientes.edit', $paciente),
            route('panel.citas.index'),
            route('panel.citas.create'),
            route('panel.citas.show', $cita),
            route('panel.citas.edit', $cita),
            route('panel.consultas.index'),
            route('panel.consultas.create'),
            route('panel.consultas.show', $consulta),
            route('panel.consultas.edit', $consulta),
            route('panel.recetas.index'),
            route('panel.recetas.create'),
            route('panel.recetas.show', $receta),
            route('panel.recetas.edit', $receta),
            route('panel.recetas.imprimir', $receta),
            route('panel.estudios.index'),
            route('panel.estudios.create'),
            route('panel.estudios.show', $estudio),
            route('panel.estudios.edit', $estudio),
            route('panel.estudios.descargar', $estudio),
            route('panel.medicos.index'),
            route('panel.medicos.create'),
            route('panel.medicos.show', $medico),
            route('panel.medicos.edit', $medico),
            route('panel.usuarios.index'),
            route('panel.usuarios.create'),
            route('panel.usuarios.edit', $admin),
        ];

        foreach ($rutas as $ruta) {
            $this->actingAs($admin)
                ->get($ruta)
                ->assertOk();
        }
    }
}
