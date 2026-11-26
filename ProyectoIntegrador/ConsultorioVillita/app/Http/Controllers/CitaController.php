<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    private const ESTADOS = ['pendiente', 'confirmada', 'cancelada', 'atendida'];

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('q'));

        $citas = Cita::with(['paciente', 'medico.usuario'])
            ->when($buscar !== '', fn ($query) => $query->whereHas(
                'paciente',
                fn ($subconsulta) => $subconsulta->whereLike('nombre', "%{$buscar}%")
            ))
            ->when($request->filled('estado'), fn ($query) => $query->where('estado', $request->input('estado')))
            ->when($request->filled('fecha'), fn ($query) => $query->whereDate('fecha', $request->date('fecha')))
            ->orderBy('fecha')
            ->paginate(12)
            ->withQueryString();

        return view('panel.citas.index', [
            'citas' => $citas,
            'estados' => self::ESTADOS,
            'buscar' => $buscar,
        ]);
    }

    public function create(): View
    {
        return view('panel.citas.create', $this->catalogos());
    }

    public function store(Request $request): RedirectResponse
    {
        $cita = Cita::create($request->validate($this->reglas()));

        return redirect()
            ->route('panel.citas.show', $cita)
            ->with('exito', 'La cita se agendó correctamente.');
    }

    public function show(Cita $cita): View
    {
        $cita->load(['paciente', 'medico.usuario', 'consulta']);

        return view('panel.citas.show', compact('cita'));
    }

    public function edit(Cita $cita): View
    {
        return view('panel.citas.edit', ['cita' => $cita] + $this->catalogos());
    }

    public function update(Request $request, Cita $cita): RedirectResponse
    {
        $cita->update($request->validate($this->reglas()));

        return redirect()
            ->route('panel.citas.show', $cita)
            ->with('exito', 'La cita se actualizó correctamente.');
    }

    public function destroy(Cita $cita): RedirectResponse
    {
        abort_unless(in_array(auth()->user()?->rol, ['admin', 'recepcionista'], true), 403);

        $cita->delete();

        return redirect()
            ->route('panel.citas.index')
            ->with('exito', 'La cita se eliminó correctamente.');
    }

    public function actualizarEstado(Request $request, Cita $cita): RedirectResponse
    {
        $datos = $request->validate([
            'estado' => ['required', 'in:pendiente,confirmada,cancelada,atendida'],
        ]);

        $cita->update($datos);

        return back()->with('exito', 'El estado de la cita se actualizó.');
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function reglas(): array
    {
        return [
            'id_paciente' => ['required', 'exists:pacientes,id_paciente'],
            'id_medico' => ['nullable', 'exists:medicos,id_medico'],
            'fecha' => ['required', 'date'],
            'duracion_minutos' => ['required', 'integer', 'between:15,240'],
            'motivo' => ['nullable', 'string', 'max:255'],
            'estado' => ['required', 'in:pendiente,confirmada,cancelada,atendida'],
            'observaciones' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function catalogos(): array
    {
        return [
            'pacientes' => Paciente::orderBy('nombre')->get(),
            'medicos' => Medico::with('usuario')->orderBy('especialidad')->get(),
            'estados' => self::ESTADOS,
        ];
    }
}
