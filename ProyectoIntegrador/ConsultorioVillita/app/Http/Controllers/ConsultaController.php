<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('q'));

        $consultas = Consulta::with(['paciente', 'medico.usuario'])
            ->when($buscar !== '', fn ($query) => $query->where(function ($subconsulta) use ($buscar) {
                $subconsulta->whereLike('diagnostico', "%{$buscar}%")
                    ->orWhereHas('paciente', fn ($paciente) => $paciente->whereLike('nombre', "%{$buscar}%"));
            }))
            ->when($request->filled('mes'), function ($query) use ($request) {
                $fecha = $request->date('mes');
                $query->whereYear('fecha', $fecha->year)->whereMonth('fecha', $fecha->month);
            })
            ->orderByDesc('fecha')
            ->paginate(12)
            ->withQueryString();

        return view('panel.consultas.index', compact('consultas', 'buscar'));
    }

    public function create(Request $request): View
    {
        return view('panel.consultas.create', $this->catalogos($request->integer('paciente'), $request->integer('cita') ?: null));
    }

    public function store(Request $request): RedirectResponse
    {
        $consulta = Consulta::create($request->validate($this->reglas()));
        $this->sincronizarPacienteYCita($consulta);

        return redirect()
            ->route('panel.consultas.show', $consulta)
            ->with('exito', 'La consulta se registró correctamente.');
    }

    public function show(Consulta $consulta): View
    {
        $consulta->load([
            'paciente',
            'medico.usuario',
            'cita',
            'recetas.medicamentos',
            'estudios',
        ]);

        return view('panel.consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta): View
    {
        return view('panel.consultas.edit', ['consulta' => $consulta] + $this->catalogos($consulta->id_paciente, $consulta->id_cita));
    }

    public function update(Request $request, Consulta $consulta): RedirectResponse
    {
        $consulta->update($request->validate($this->reglas()));
        $this->sincronizarPacienteYCita($consulta);

        return redirect()
            ->route('panel.consultas.show', $consulta)
            ->with('exito', 'La consulta se actualizó correctamente.');
    }

    public function destroy(Consulta $consulta): RedirectResponse
    {
        $consulta->delete();

        return redirect()
            ->route('panel.consultas.index')
            ->with('exito', 'La consulta se eliminó correctamente.');
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function reglas(): array
    {
        return [
            'id_paciente' => ['required', 'exists:pacientes,id_paciente'],
            'id_medico' => ['nullable', 'exists:medicos,id_medico'],
            'id_cita' => ['nullable', 'exists:citas,id_cita'],
            'fecha' => ['required', 'date'],
            'motivo' => ['required', 'string'],
            'antecedentes' => ['nullable', 'string'],
            'signos_vitales' => ['nullable', 'string'],
            'revision_fisica' => ['nullable', 'string'],
            'diagnostico' => ['nullable', 'string'],
            'tratamiento' => ['nullable', 'string'],
            'resultados' => ['nullable', 'string'],
            'notas' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function catalogos(int $idPaciente = 0, ?int $idCita = null): array
    {
        return [
            'pacientes' => Paciente::orderBy('nombre')->get(),
            'medicos' => Medico::with('usuario')->orderBy('especialidad')->get(),
            'citas' => Cita::with('paciente')
                ->where(function ($query) use ($idCita) {
                    $query->whereDoesntHave('consulta');

                    if ($idCita) {
                        $query->orWhere('id_cita', $idCita);
                    }
                })
                ->orderByDesc('fecha')
                ->take(60)
                ->get(),
            'idPaciente' => $idPaciente,
        ];
    }

    private function sincronizarPacienteYCita(Consulta $consulta): void
    {
        $paciente = $consulta->paciente;

        if ($paciente && (! $paciente->ultima_consulta || $consulta->fecha->greaterThan($paciente->ultima_consulta))) {
            $paciente->update(['ultima_consulta' => $consulta->fecha]);
        }

        if ($consulta->id_cita) {
            $consulta->cita?->update(['estado' => 'atendida']);
        }
    }
}
