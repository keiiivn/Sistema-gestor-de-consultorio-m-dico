<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicoController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('q'));

        $medicos = Medico::with('usuario')
            ->withCount(['pacientes', 'citas', 'consultas'])
            ->when($buscar !== '', fn ($query) => $query->where(function ($subconsulta) use ($buscar) {
                $subconsulta->whereLike('cedula', "%{$buscar}%")
                    ->orWhereLike('especialidad', "%{$buscar}%")
                    ->orWhereHas('usuario', fn ($usuario) => $usuario->whereLike('nombre', "%{$buscar}%"));
            }))
            ->orderBy('especialidad')
            ->paginate(10)
            ->withQueryString();

        return view('panel.medicos.index', compact('medicos', 'buscar'));
    }

    public function create(): View
    {
        return view('panel.medicos.create', [
            'usuarios' => Usuario::where('rol', 'medico')->whereDoesntHave('medico')->orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $medico = Medico::create($request->validate($this->reglas()));

        return redirect()
            ->route('panel.medicos.index')
            ->with('exito', "El médico {$medico->nombre} se registró correctamente.");
    }

    public function show(Medico $medico): View
    {
        $medico->load('usuario');
        $medico->loadCount(['pacientes', 'citas', 'consultas']);

        $citas = $medico->citas()
            ->with('paciente')
            ->orderByDesc('fecha')
            ->take(8)
            ->get();

        return view('panel.medicos.show', compact('medico', 'citas'));
    }

    public function edit(Medico $medico): View
    {
        return view('panel.medicos.edit', [
            'medico' => $medico,
            'usuarios' => Usuario::where('rol', 'medico')
                ->where(function ($query) use ($medico) {
                    $query->whereDoesntHave('medico')
                        ->orWhere('id_usuario', $medico->id_usuario);
                })
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function update(Request $request, Medico $medico): RedirectResponse
    {
        $medico->update($request->validate($this->reglas($medico)));

        return redirect()
            ->route('panel.medicos.index')
            ->with('exito', 'Los datos del médico se actualizaron.');
    }

    public function destroy(Medico $medico): RedirectResponse
    {
        $medico->delete();

        return redirect()
            ->route('panel.medicos.index')
            ->with('exito', 'El médico se eliminó correctamente.');
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function reglas(?Medico $medico = null): array
    {
        return [
            'id_usuario' => [
                'nullable',
                'exists:usuarios,id_usuario',
                Rule::unique('medicos', 'id_usuario')->ignore($medico?->id_medico, 'id_medico'),
            ],
            'cedula' => [
                'required',
                'string',
                'max:50',
                Rule::unique('medicos', 'cedula')->ignore($medico?->id_medico, 'id_medico'),
            ],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'consultorio' => ['nullable', 'string', 'max:50'],
            'biografia' => ['nullable', 'string'],
        ];
    }
}
