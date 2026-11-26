<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Estudio;
use App\Models\Paciente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstudioController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('q'));

        $estudios = Estudio::with(['paciente', 'consulta'])
            ->when($buscar !== '', fn ($query) => $query->where(function ($subconsulta) use ($buscar) {
                $subconsulta->whereLike('nombre_archivo', "%{$buscar}%")
                    ->orWhereHas('paciente', fn ($paciente) => $paciente->whereLike('nombre', "%{$buscar}%"));
            }))
            ->when($request->filled('tipo'), fn ($query) => $query->where('tipo', $request->input('tipo')))
            ->orderByDesc('fecha_subida')
            ->paginate(12)
            ->withQueryString();

        return view('panel.estudios.index', [
            'estudios' => $estudios,
            'buscar' => $buscar,
            'tipos' => Estudio::query()->whereNotNull('tipo')->distinct()->orderBy('tipo')->pluck('tipo'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('panel.estudios.create', [
            'pacientes' => Paciente::orderBy('nombre')->get(),
            'consultas' => Consulta::with('paciente')->orderByDesc('fecha')->take(60)->get(),
            'idPaciente' => $request->integer('paciente'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate($this->reglas());
        $archivo = $request->file('archivo');

        $datos['ruta_archivo'] = $archivo->store('estudios', 'local');
        $datos['nombre_archivo'] = $archivo->getClientOriginalName();
        $datos['fecha_subida'] = now();

        if (! filled($datos['tipo'] ?? null)) {
            $datos['tipo'] = 'Otro';
        }

        $estudio = Estudio::create($datos);

        return redirect()
            ->route('panel.estudios.show', $estudio)
            ->with('exito', 'El estudio se subió correctamente.');
    }

    public function show(Estudio $estudio): View
    {
        $estudio->load(['paciente', 'consulta']);

        return view('panel.estudios.show', compact('estudio'));
    }

    public function edit(Estudio $estudio): View
    {
        return view('panel.estudios.edit', [
            'estudio' => $estudio,
            'pacientes' => Paciente::orderBy('nombre')->get(),
            'consultas' => Consulta::with('paciente')->orderByDesc('fecha')->take(60)->get(),
        ]);
    }

    public function update(Request $request, Estudio $estudio): RedirectResponse
    {
        $datos = $request->validate($this->reglas(true));

        if ($request->hasFile('archivo')) {
            if (Storage::disk('local')->exists($estudio->ruta_archivo)) {
                Storage::disk('local')->delete($estudio->ruta_archivo);
            }

            $archivo = $request->file('archivo');
            $datos['ruta_archivo'] = $archivo->store('estudios', 'local');
            $datos['nombre_archivo'] = $archivo->getClientOriginalName();
            $datos['fecha_subida'] = now();
        }

        $estudio->update($datos);

        return redirect()
            ->route('panel.estudios.show', $estudio)
            ->with('exito', 'El estudio se actualizó correctamente.');
    }

    public function destroy(Estudio $estudio): RedirectResponse
    {
        if (Storage::disk('local')->exists($estudio->ruta_archivo)) {
            Storage::disk('local')->delete($estudio->ruta_archivo);
        }

        $estudio->delete();

        return redirect()
            ->route('panel.estudios.index')
            ->with('exito', 'El estudio se eliminó correctamente.');
    }

    public function descargar(Estudio $estudio)
    {
        if (! Storage::disk('local')->exists($estudio->ruta_archivo)) {
            return back()->with('error', 'El archivo ya no se encuentra disponible.');
        }

        return Storage::disk('local')->download($estudio->ruta_archivo, $estudio->nombre_archivo);
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function reglas(bool $esActualizacion = false): array
    {
        return [
            'id_paciente' => ['required', 'exists:pacientes,id_paciente'],
            'id_consulta' => ['nullable', 'exists:consultas,id_consulta'],
            'tipo' => ['nullable', 'string', 'max:80'],
            'descripcion' => ['nullable', 'string'],
            'archivo' => [
                $esActualizacion ? 'nullable' : 'required',
                'file',
                'max:10240',
                'mimes:pdf,jpg,jpeg,png,webp,doc,docx',
            ],
        ];
    }
}
