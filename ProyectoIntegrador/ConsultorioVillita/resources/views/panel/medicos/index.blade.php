@extends('layouts.app')

@section('title', 'Médicos')
@section('titulo', 'Médicos')
@section('subtitulo', 'Equipo médico del consultorio')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-2xl text-sage-900">Equipo médico</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $medicos->total() }} médicos registrados</p>
        </div>
        <a href="{{ route('panel.medicos.create') }}" class="btn-primary px-5 py-2.5">
            <x-icon name="plus" class="size-4" />
            Nuevo médico
        </a>
    </div>

    <form method="GET" action="{{ route('panel.medicos.index') }}" class="card mt-6 flex flex-col gap-3 p-4 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-stone-400" />
            <input type="search" name="q" value="{{ $buscar }}" placeholder="Buscar por nombre, cédula o especialidad" class="input-base pl-10">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary px-5 py-2.5">Buscar</button>
            @if (request()->filled('q'))
                <a href="{{ route('panel.medicos.index') }}" class="btn-ghost">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card mt-6 overflow-hidden">
        @if ($medicos->isEmpty())
            <x-empty-state icon="stethoscope" title="Aún no hay médicos registrados" description="Crea un usuario con rol médico y después registra su perfil profesional.">
                <x-slot:accion>
                    <a href="{{ route('panel.medicos.create') }}" class="btn-primary px-5 py-2.5">Registrar médico</a>
                </x-slot:accion>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Médico</th>
                            <th class="table-head">Cédula</th>
                            <th class="table-head">Consultorio</th>
                            <th class="table-head">Pacientes</th>
                            <th class="table-head">Citas</th>
                            <th class="table-head">Estado</th>
                            <th class="table-head text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($medicos as $medico)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell">
                                    <a href="{{ route('panel.medicos.show', $medico) }}" class="flex items-center gap-3">
                                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-sage-100 text-sm font-semibold text-sage-700">
                                            {{ mb_strtoupper(mb_substr($medico->nombre, 0, 1)) }}
                                        </span>
                                        <span>
                                            <span class="block font-medium text-stone-800">{{ $medico->nombre }}</span>
                                            <span class="block text-xs text-stone-400">{{ $medico->especialidad ?: 'Sin especialidad' }}</span>
                                        </span>
                                    </a>
                                </td>
                                <td class="table-cell font-mono text-xs">{{ $medico->cedula }}</td>
                                <td class="table-cell">{{ $medico->consultorio ?: '—' }}</td>
                                <td class="table-cell">{{ $medico->pacientes_count }}</td>
                                <td class="table-cell">{{ $medico->citas_count }}</td>
                                <td class="table-cell">
                                    @if ($medico->activo)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sage-50 px-2.5 py-1 text-xs font-medium text-sage-700 ring-1 ring-inset ring-sage-200">
                                            <span class="size-1.5 rounded-full bg-sage-500"></span> Activo
                                        </span>
                                    @else
                                        <span class="rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-500">Inactivo</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('panel.medicos.show', $medico) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Ver perfil">
                                            <x-icon name="eye" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.medicos.edit', $medico) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Editar">
                                            <x-icon name="edit" class="size-4" />
                                        </a>
                                        <form method="POST" action="{{ route('panel.medicos.destroy', $medico) }}" data-confirm="¿Eliminar el perfil de {{ $medico->nombre }}? Sus pacientes y citas quedarán sin médico asignado.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-rose-50 hover:text-rose-600" title="Eliminar">
                                                <x-icon name="trash" class="size-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-stone-100 px-5 py-4">
                {{ $medicos->links() }}
            </div>
        @endif
    </div>
@endsection
