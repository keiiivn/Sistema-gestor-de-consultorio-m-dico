<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Receta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('q'));

        $recetas = Receta::with(['consulta.paciente', 'consulta.medico.usuario', 'medicamentos'])
            ->when($buscar !== '', fn ($query) => $query->where(function ($subconsulta) use ($buscar) {
                $subconsulta->whereLike('nombre_paciente', "%{$buscar}%")
                    ->orWhereHas('consulta.paciente', fn ($paciente) => $paciente->whereLike('nombre', "%{$buscar}%"));
            }))
            ->orderByDesc('fecha_registro')
            ->paginate(12)
            ->withQueryString();

        return view('panel.recetas.index', compact('recetas', 'buscar'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $consultas = Consulta::with('paciente')->orderByDesc('fecha')->take(60)->get();

        if ($consultas->isEmpty()) {
            return redirect()
                ->route('panel.recetas.index')
                ->with('error', 'Primero registra una consulta para poder generar una receta.');
        }

        return view('panel.recetas.create', [
            'consultas' => $consultas,
            'idConsulta' => $request->integer('consulta'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $receta = DB::transaction(function () use ($request) {
            $datos = $request->validate($this->reglas());
            $datos = $this->completarDatosDelPaciente($datos);

            $receta = Receta::create(Arr::except($datos, 'medicamentos'));
            $this->guardarMedicamentos($receta, $datos['medicamentos'] ?? []);

            return $receta;
        });

        return redirect()
            ->route('panel.recetas.show', $receta)
            ->with('exito', 'La receta se creó correctamente.');
    }

    public function show(Receta $receta): View
    {
        $receta->load(['consulta.paciente', 'consulta.medico.usuario', 'medicamentos']);

        return view('panel.recetas.show', compact('receta'));
    }

    public function imprimir(Receta $receta): View
    {
        $receta->load(['consulta.paciente', 'consulta.medico.usuario', 'medicamentos']);

        return view('panel.recetas.print', compact('receta'));
    }

    public function edit(Receta $receta): View
    {
        $receta->load('medicamentos');

        return view('panel.recetas.edit', [
            'receta' => $receta,
            'consultas' => Consulta::with('paciente')->orderByDesc('fecha')->take(60)->get(),
        ]);
    }

    public function update(Request $request, Receta $receta): RedirectResponse
    {
        DB::transaction(function () use ($request, $receta) {
            $datos = $request->validate($this->reglas());
            $datos = $this->completarDatosDelPaciente($datos);

            $receta->update(Arr::except($datos, 'medicamentos'));
            $receta->medicamentos()->delete();
            $this->guardarMedicamentos($receta, $datos['medicamentos'] ?? []);
        });

        return redirect()
            ->route('panel.recetas.show', $receta)
            ->with('exito', 'La receta se actualizó correctamente.');
    }

    public function destroy(Receta $receta): RedirectResponse
    {
        $receta->delete();

        return redirect()
            ->route('panel.recetas.index')
            ->with('exito', 'La receta se eliminó correctamente.');
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function reglas(): array
    {
        return [
            'id_consulta' => ['required', 'exists:consultas,id_consulta'],
            'nombre_paciente' => ['nullable', 'string', 'max:100'],
            'edad' => ['nullable', 'integer', 'between:0,120'],
            'altura' => ['nullable', 'numeric', 'between:0,3'],
            'peso' => ['nullable', 'numeric', 'between:0,500'],
            'indicaciones' => ['nullable', 'string'],
            'medicamentos' => ['nullable', 'array'],
            'medicamentos.*.medicamento' => ['nullable', 'string', 'max:150'],
            'medicamentos.*.presentacion' => ['nullable', 'string', 'max:100'],
            'medicamentos.*.dosis' => ['nullable', 'string', 'max:100'],
            'medicamentos.*.frecuencia' => ['nullable', 'string', 'max:100'],
            'medicamentos.*.duracion' => ['nullable', 'string', 'max:100'],
            'medicamentos.*.via_administracion' => ['nullable', 'string', 'max:50'],
            'medicamentos.*.indicaciones' => ['nullable', 'string'],
        ];
    }

    /**
     * @param  array<string, mixed>  $datos
     * @return array<string, mixed>
     */
    private function completarDatosDelPaciente(array $datos): array
    {
        $consulta = Consulta::with('paciente')->find($datos['id_consulta']);

        $datos['nombre_paciente'] = ($datos['nombre_paciente'] ?? null) ?: $consulta?->paciente?->nombre;
        $datos['edad'] = ($datos['edad'] ?? null) ?: $consulta?->paciente?->edad;

        return $datos;
    }

    /**
     * @param  array<int, array<string, mixed>>  $medicamentos
     */
    private function guardarMedicamentos(Receta $receta, array $medicamentos): void
    {
        foreach ($medicamentos as $medicamento) {
            if (! filled($medicamento['medicamento'] ?? null)) {
                continue;
            }

            $receta->medicamentos()->create($medicamento);
        }
    }
}
