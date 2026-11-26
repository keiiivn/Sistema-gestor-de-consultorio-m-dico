@extends('layouts.app')

@section('title', 'Usuarios')
@section('titulo', 'Usuarios')
@section('subtitulo', 'Accesos y roles del personal')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-2xl text-sage-900">Usuarios del sistema</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $usuarios->total() }} cuentas registradas</p>
        </div>
        <a href="{{ route('panel.usuarios.create') }}" class="btn-primary px-5 py-2.5">
            <x-icon name="plus" class="size-4" />
            Nuevo usuario
        </a>
    </div>

    <form method="GET" action="{{ route('panel.usuarios.index') }}" class="card mt-6 flex flex-col gap-3 p-4 lg:flex-row lg:items-center">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-stone-400" />
            <input type="search" name="q" value="{{ $buscar }}" placeholder="Buscar por nombre, usuario o correo" class="input-base pl-10">
        </div>
        <div class="lg:w-52">
            <select name="rol" class="input-base cursor-pointer">
                <option value="">Todos los roles</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol }}" @selected(request('rol') === $rol)>{{ ucfirst($rol) }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary px-5 py-2.5">Filtrar</button>
            @if (request()->filled('q') || request()->filled('rol'))
                <a href="{{ route('panel.usuarios.index') }}" class="btn-ghost">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card mt-6 overflow-hidden">
        @if ($usuarios->isEmpty())
            <x-empty-state icon="lock" title="No hay usuarios con estos filtros" description="Prueba otra búsqueda o crea una nueva cuenta." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Usuario</th>
                            <th class="table-head">Correo</th>
                            <th class="table-head">Rol</th>
                            <th class="table-head">Estado</th>
                            <th class="table-head text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($usuarios as $usuario)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell">
                                    <div class="flex items-center gap-3">
                                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-sage-100 text-sm font-semibold text-sage-700">
                                            {{ mb_strtoupper(mb_substr($usuario->nombre, 0, 1)) }}
                                        </span>
                                        <span>
                                            <span class="block font-medium text-stone-800">{{ $usuario->nombre }}</span>
                                            <span class="block font-mono text-xs text-stone-400">{{ $usuario->usuario }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="table-cell">{{ $usuario->email }}</td>
                                <td class="table-cell">
                                    @php
                                        $rolClass = match ($usuario->rol) {
                                            'admin' => 'bg-sage-50 text-sage-700 ring-sage-200',
                                            'medico' => 'bg-cream-100 text-clay-600 ring-cream-300',
                                            default => 'bg-stone-100 text-stone-600 ring-stone-200',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium capitalize ring-1 ring-inset {{ $rolClass }}">
                                        {{ $usuario->rol }}
                                    </span>
                                </td>
                                <td class="table-cell">
                                    @if ($usuario->activo)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sage-50 px-2.5 py-1 text-xs font-medium text-sage-700 ring-1 ring-inset ring-sage-200">
                                            <span class="size-1.5 rounded-full bg-sage-500"></span> Activo
                                        </span>
                                    @else
                                        <span class="rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-500">Inactivo</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('panel.usuarios.edit', $usuario) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Editar">
                                            <x-icon name="edit" class="size-4" />
                                        </a>
                                        @if ($usuario->id_usuario !== auth()->id())
                                            <form method="POST" action="{{ route('panel.usuarios.destroy', $usuario) }}" data-confirm="¿Eliminar la cuenta de {{ $usuario->nombre }}?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-rose-50 hover:text-rose-600" title="Eliminar">
                                                    <x-icon name="trash" class="size-4" />
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-stone-100 px-5 py-4">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>
@endsection
