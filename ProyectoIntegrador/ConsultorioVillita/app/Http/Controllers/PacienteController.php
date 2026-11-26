<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('q'));

        $pacientes = Paciente::with('medico.usuario')
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subconsulta) use ($buscar) {
                    $subconsulta->whereLike('nombre', "%{$buscar}%")
                        ->orWhereLike('telefono', "%{$buscar}%")
                        ->orWhereLike('email', "%{$buscar}%");
                });
            })
            ->when($request->filled('medico'), fn ($query) => $query->where('id_medico', $request->integer('medico')))
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();

        $medicos = Medico::with('usuario')->orderBy('especialidad')->get();

        return view('panel.pacientes.index', compact('pacientes', 'medicos', 'buscar'));
    }

    public function create(): View
    {
        $medicos = Medico::with('usuario')->orderBy('especialidad')->get();

        return view('panel.pacientes.create', compact('medicos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate($this->reglas());
        $datos['activo'] = $request->boolean('activo');
        $datos['fecha_registro'] = now();

        $paciente = Paciente::create($datos);

        return redirect()
            ->route('panel.pacientes.show', $paciente)
            ->with('exito', 'El paciente se registró correctamente.');
    }

    public function show(Paciente $paciente): View
    {
        $paciente->load([
            'medico.usuario',
            'citas' => fn ($query) => $query->orderByDesc('fecha')->take(8),
            'consultas' => fn ($query) => $query->with('medico.usuario')->orderByDesc('fecha')->take(8),
            'estudios' => fn ($query) => $query->orderByDesc('fecha_subida')->take(8),
        ]);

        return view('panel.pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente): View
    {
        $medicos = Medico::with('usuario')->orderBy('especialidad')->get();

        return view('panel.pacientes.edit', compact('paciente', 'medicos'));
    }

    public function update(Request $request, Paciente $paciente): RedirectResponse
    {
        $datos = $request->validate($this->reglas($paciente));
        $datos['activo'] = $request->boolean('activo');

        $paciente->update($datos);

        return redirect()
            ->route('panel.pacientes.show', $paciente)
            ->with('exito', 'Los datos del paciente se actualizaron.');
    }

    public function destroy(Paciente $paciente): RedirectResponse
    {
        abort_unless(auth()->user()?->esAdmin(), 403);

        $paciente->delete();

        return redirect()
            ->route('panel.pacientes.index')
            ->with('exito', 'El paciente se eliminó correctamente.');
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function reglas(?Paciente $paciente = null): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:today'],
            'sexo' => ['required', 'in:M,F'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:200'],
            'padecimiento' => ['nullable', 'string', 'max:200'],
            'alergias' => ['nullable', 'string'],
            'antecedentes' => ['nullable', 'string'],
            'id_medico' => ['nullable', 'exists:medicos,id_medico'],
        ];
    }
}
