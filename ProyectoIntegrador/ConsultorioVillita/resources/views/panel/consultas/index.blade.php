@extends('layouts.app')

@section('title', 'Consultas')
@section('titulo', 'Consultas')
@section('subtitulo', 'Historial de atenciones médicas')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-2xl text-sage-900">Historial de consultas</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $consultas->total() }} consultas registradas</p>
        </div>
        <a href="{{ route('panel.consultas.create') }}" class="btn-primary px-5 py-2.5">
            <x-icon name="plus" class="size-4" />
            Nueva consulta
        </a>
    </div>

    <form method="GET" action="{{ route('panel.consultas.index') }}" class="card mt-6 flex flex-col gap-3 p-4 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-stone-400" />
            <input type="search" name="q" value="{{ $buscar }}" placeholder="Buscar por paciente o diagnóstico" class="input-base pl-10">
        </div>
        <div class="sm:w-48">
            <input type="month" name="mes" value="{{ request('mes') }}" class="input-base">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary px-5 py-2.5">Filtrar</button>
            @if (request()->filled('q') || request()->filled('mes'))
                <a href="{{ route('panel.consultas.index') }}" class="btn-ghost">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card mt-6 overflow-hidden">
        @if ($consultas->isEmpty())
            <x-empty-state icon="stethoscope" title="No hay consultas registradas" description="Cuando atiendas a un paciente, registra aquí la consulta para conservar su historial.">
                <x-slot:accion>
                    <a href="{{ route('panel.consultas.create') }}" class="btn-primary px-5 py-2.5">Registrar consulta</a>
                </x-slot:accion>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[860px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Fecha</th>
                            <th class="table-head">Paciente</th>
                            <th class="table-head">Médico</th>
                            <th class="table-head">Diagnóstico</th>
                            <th class="table-head">Motivo</th>
                            <th class="table-head text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($consultas as $consulta)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell whitespace-nowrap">
                                    <span class="font-medium text-stone-700">{{ $consulta->fecha->translatedFormat('d M Y') }}</span>
                                    <span class="block text-xs text-stone-400">{{ $consulta->fecha->format('H:i') }} hrs</span>
                                </td>
                                <td class="table-cell">
                                    <a href="{{ route('panel.pacientes.show', $consulta->paciente) }}" class="font-medium text-stone-700 hover:text-sage-700">
                                        {{ $consulta->paciente?->nombre }}
                                    </a>
                                </td>
                                <td class="table-cell">{{ $consulta->medico?->nombre ?? 'Sin asignar' }}</td>
                                <td class="table-cell">
                                    <span class="line-clamp-1">{{ $consulta->diagnostico ?: 'Sin diagnóstico' }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="line-clamp-1 text-stone-500">{{ $consulta->motivo }}</span>
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('panel.consultas.show', $consulta) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Ver consulta">
                                            <x-icon name="eye" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.consultas.edit', $consulta) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Editar">
                                            <x-icon name="edit" class="size-4" />
                                        </a>
                                        <form method="POST" action="{{ route('panel.consultas.destroy', $consulta) }}" data-confirm="¿Eliminar esta consulta? También se eliminarán sus recetas.">
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
                {{ $consultas->links() }}
            </div>
        @endif
    </div>
@endsection
