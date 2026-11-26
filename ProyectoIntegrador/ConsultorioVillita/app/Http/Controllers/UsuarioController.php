<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    private const ROLES = ['admin', 'medico', 'recepcionista'];

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('q'));

        $usuarios = Usuario::with('medico')
            ->when($buscar !== '', fn ($query) => $query->where(function ($subconsulta) use ($buscar) {
                $subconsulta->whereLike('nombre', "%{$buscar}%")
                    ->orWhereLike('usuario', "%{$buscar}%")
                    ->orWhereLike('email', "%{$buscar}%");
            }))
            ->when($request->filled('rol'), fn ($query) => $query->where('rol', $request->input('rol')))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('panel.usuarios.index', [
            'usuarios' => $usuarios,
            'buscar' => $buscar,
            'roles' => self::ROLES,
        ]);
    }

    public function create(): View
    {
        return view('panel.usuarios.create', ['roles' => self::ROLES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate($this->reglas());
        $datos['activo'] = $request->boolean('activo');

        $usuario = Usuario::create($datos);

        return redirect()
            ->route('panel.usuarios.index')
            ->with('exito', "El usuario {$usuario->nombre} se creó correctamente.");
    }

    public function edit(Usuario $usuario): View
    {
        return view('panel.usuarios.edit', [
            'usuario' => $usuario,
            'roles' => self::ROLES,
        ]);
    }

    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $datos = $request->validate($this->reglas($usuario));

        if (blank($datos['password'] ?? null)) {
            unset($datos['password']);
        }

        $datos['activo'] = $request->boolean('activo');

        if ($usuario->id_usuario === auth()->id() && ! $datos['activo']) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario->update($datos);

        return redirect()
            ->route('panel.usuarios.index')
            ->with('exito', 'El usuario se actualizó correctamente.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        if ($usuario->id_usuario === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        if ($usuario->esAdmin() && Usuario::where('rol', 'admin')->count() <= 1) {
            return back()->with('error', 'Debe existir al menos un administrador activo.');
        }

        $usuario->delete();

        return redirect()
            ->route('panel.usuarios.index')
            ->with('exito', 'El usuario se eliminó correctamente.');
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function reglas(?Usuario $usuario = null): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'usuario' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('usuarios', 'usuario')->ignore($usuario?->id_usuario, 'id_usuario'),
            ],
            'email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('usuarios', 'email')->ignore($usuario?->id_usuario, 'id_usuario'),
            ],
            'password' => [$usuario ? 'nullable' : 'required', 'string', 'min:8'],
            'rol' => ['required', 'in:admin,medico,recepcionista'],
            'telefono' => ['nullable', 'string', 'max:20'],
        ];
    }
}
