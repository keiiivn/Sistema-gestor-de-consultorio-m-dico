@extends('layouts.app')

@section('title', 'Citas')
@section('titulo', 'Citas')
@section('subtitulo', 'Agenda del consultorio')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-2xl text-sage-900">Agenda de citas</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $citas->total() }} citas encontradas</p>
        </div>
        <a href="{{ route('panel.citas.create') }}" class="btn-primary px-5 py-2.5">
            <x-icon name="plus" class="size-4" />
            Nueva cita
        </a>
    </div>

    <form method="GET" action="{{ route('panel.citas.index') }}" class="card mt-6 flex flex-col gap-3 p-4 lg:flex-row lg:items-center">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-stone-400" />
            <input type="search" name="q" value="{{ $buscar }}" placeholder="Buscar por paciente" class="input-base pl-10">
        </div>

        <div class="lg:w-44">
            <select name="estado" class="input-base cursor-pointer">
                <option value="">Todos los estados</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado }}" @selected(request('estado') === $estado)>{{ ucfirst($estado) }}</option>
                @endforeach
            </select>
        </div>

        <div class="lg:w-44">
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="input-base">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="btn-primary px-5 py-2.5">Filtrar</button>
            @if (request()->filled('q') || request()->filled('estado') || request()->filled('fecha'))
                <a href="{{ route('panel.citas.index') }}" class="btn-ghost">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card mt-6 overflow-hidden">
        @if ($citas->isEmpty())
            <x-empty-state icon="calendar" title="No hay citas con estos filtros" description="Prueba con otro rango de fecha o agenda una nueva cita.">
                <x-slot:accion>
                    <a href="{{ route('panel.citas.create') }}" class="btn-primary px-5 py-2.5">Agendar cita</a>
                </x-slot:accion>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Fecha</th>
                            <th class="table-head">Paciente</th>
                            <th class="table-head">Médico</th>
                            <th class="table-head">Motivo</th>
                            <th class="table-head">Estado</th>
                            <th class="table-head text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($citas as $cita)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell whitespace-nowrap">
                                    <span class="font-medium text-stone-700">{{ $cita->fecha->translatedFormat('D d M Y') }}</span>
                                    <span class="mt-0.5 flex items-center gap-1 text-xs text-stone-400">
                                        <x-icon name="clock" class="size-3" />
                                        {{ $cita->fecha->format('H:i') }} · {{ $cita->duracion_minutos }} min
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <a href="{{ route('panel.pacientes.show', $cita->paciente) }}" class="font-medium text-stone-700 hover:text-sage-700">
                                        {{ $cita->paciente?->nombre }}
                                    </a>
                                </td>
                                <td class="table-cell">{{ $cita->medico?->nombre ?? 'Sin asignar' }}</td>
                                <td class="table-cell">{{ $cita->motivo ?: '—' }}</td>
                                <td class="table-cell">
                                    <form method="POST" action="{{ route('panel.citas.estado', $cita) }}" class="flex items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="estado" onchange="this.form.submit()" class="rounded-full border border-stone-200 bg-white py-1 pl-2.5 pr-7 text-xs text-stone-600 outline-none focus:border-sage-400">
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado }}" @selected($cita->estado === $estado)>{{ ucfirst($estado) }}</option>
                                            @endforeach
                                        </select>
                                        <noscript><button type="submit" class="text-xs text-sage-600">Guardar</button></noscript>
                                    </form>
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('panel.citas.show', $cita) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Ver cita">
                                            <x-icon name="eye" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.citas.edit', $cita) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Editar">
                                            <x-icon name="edit" class="size-4" />
                                        </a>
                                        @if (in_array(auth()->user()->rol, ['admin', 'recepcionista'], true))
                                            <form method="POST" action="{{ route('panel.citas.destroy', $cita) }}" data-confirm="¿Eliminar esta cita?">
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
                {{ $citas->links() }}
            </div>
        @endif
    </div>
@endsection
