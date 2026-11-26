@extends('layouts.app')

@section('title', 'Recetas')
@section('titulo', 'Recetas')
@section('subtitulo', 'Prescripciones médicas')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-2xl text-sage-900">Recetas emitidas</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $recetas->total() }} recetas registradas</p>
        </div>
        <a href="{{ route('panel.recetas.create') }}" class="btn-primary px-5 py-2.5">
            <x-icon name="plus" class="size-4" />
            Nueva receta
        </a>
    </div>

    <form method="GET" action="{{ route('panel.recetas.index') }}" class="card mt-6 flex flex-col gap-3 p-4 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-stone-400" />
            <input type="search" name="q" value="{{ $buscar }}" placeholder="Buscar por paciente" class="input-base pl-10">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary px-5 py-2.5">Buscar</button>
            @if (request()->filled('q'))
                <a href="{{ route('panel.recetas.index') }}" class="btn-ghost">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card mt-6 overflow-hidden">
        @if ($recetas->isEmpty())
            <x-empty-state icon="pill" title="Aún no hay recetas" description="Genera una receta a partir de una consulta registrada.">
                <x-slot:accion>
                    <a href="{{ route('panel.recetas.create') }}" class="btn-primary px-5 py-2.5">Crear receta</a>
                </x-slot:accion>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[860px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Folio</th>
                            <th class="table-head">Paciente</th>
                            <th class="table-head">Consulta</th>
                            <th class="table-head">Médico</th>
                            <th class="table-head">Medicamentos</th>
                            <th class="table-head">Fecha</th>
                            <th class="table-head text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($recetas as $receta)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell">
                                    <span class="font-mono text-xs text-sage-700">#{{ str_pad((string) $receta->id_receta, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="table-cell">
                                    <a href="{{ route('panel.recetas.show', $receta) }}" class="font-medium text-stone-700 hover:text-sage-700">
                                        {{ $receta->nombre_paciente ?: $receta->consulta?->paciente?->nombre }}
                                    </a>
                                </td>
                                <td class="table-cell">
                                    @if ($receta->consulta)
                                        <a href="{{ route('panel.consultas.show', $receta->consulta) }}" class="text-stone-600 hover:text-sage-700">
                                            {{ $receta->consulta->fecha->translatedFormat('d M Y') }}
                                        </a>
                                    @else
                                        <span class="text-stone-400">—</span>
                                    @endif
                                </td>
                                <td class="table-cell">{{ $receta->consulta?->medico?->nombre ?? 'Sin asignar' }}</td>
                                <td class="table-cell">{{ $receta->medicamentos->count() }}</td>
                                <td class="table-cell whitespace-nowrap">{{ $receta->fecha_registro?->translatedFormat('d M Y') }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('panel.recetas.show', $receta) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Ver receta">
                                            <x-icon name="eye" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.recetas.imprimir', $receta) }}" target="_blank" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Imprimir">
                                            <x-icon name="print" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.recetas.edit', $receta) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Editar">
                                            <x-icon name="edit" class="size-4" />
                                        </a>
                                        <form method="POST" action="{{ route('panel.recetas.destroy', $receta) }}" data-confirm="¿Eliminar esta receta?">
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
                {{ $recetas->links() }}
            </div>
        @endif
    </div>
@endsection
