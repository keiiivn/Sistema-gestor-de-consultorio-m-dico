@extends('layouts.app')

@section('title', 'Panel general')
@section('titulo', 'Panel general')
@section('subtitulo', 'Un vistazo a la actividad del consultorio')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm text-stone-400">{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}</p>
            <h2 class="mt-1 font-display text-3xl tracking-tight text-sage-900">
                Hola, {{ str(auth()->user()->nombre)->before(' ') }}
            </h2>
            <p class="mt-1 text-sm text-stone-500">Este es el resumen de hoy. Que tengas un excelente día.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('panel.citas.create') }}" class="btn-primary px-5 py-2.5">
                <x-icon name="plus" class="size-4" />
                Nueva cita
            </a>
            <a href="{{ route('panel.pacientes.create') }}" class="btn-soft px-5 py-2.5">
                <x-icon name="user" class="size-4" />
                Nuevo paciente
            </a>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Pacientes activos" :value="$estadisticas['pacientes']" icon="users" tone="sage" />
        <x-stat-card label="Citas de hoy" :value="$estadisticas['citas_hoy']" icon="calendar" tone="cream" />
        <x-stat-card label="Consultas del mes" :value="$estadisticas['consultas_mes']" icon="stethoscope" tone="sage" />
        <x-stat-card label="Recetas del mes" :value="$estadisticas['recetas_mes']" icon="pill" tone="stone" />
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.6fr_1fr]">
        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-5">
                <div>
                    <h3 class="font-display text-xl text-sage-900">Agenda de hoy</h3>
                    <p class="mt-0.5 text-xs text-stone-400">{{ $citasHoy->count() }} citas programadas</p>
                </div>
                <a href="{{ route('panel.citas.index') }}" class="flex items-center gap-1.5 text-xs font-medium text-sage-600 hover:text-sage-800">
                    Ver todas
                    <x-icon name="arrow-right" class="size-3.5" />
                </a>
            </div>

            @if ($citasHoy->isEmpty())
                <x-empty-state icon="calendar" title="No hay citas para hoy" description="Aprovecha para revisar la agenda de los próximos días.">
                    <x-slot:accion>
                        <a href="{{ route('panel.citas.create') }}" class="btn-soft px-5 py-2.5">Agendar cita</a>
                    </x-slot:accion>
                </x-empty-state>
            @else
                <div class="divide-y divide-stone-100">
                    @foreach ($citasHoy as $cita)
                        <a href="{{ route('panel.citas.show', $cita) }}" class="flex items-center gap-4 px-6 py-4 transition hover:bg-cream-50">
                            <span class="w-14 shrink-0 rounded-xl bg-sage-50 py-2 text-center">
                                <span class="block font-display text-base leading-none text-sage-800">{{ $cita->fecha->format('H:i') }}</span>
                                <span class="mt-1 block text-[0.6rem] uppercase tracking-wider text-sage-500">{{ $cita->duracion_minutos }} min</span>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-medium text-stone-800">{{ $cita->paciente?->nombre }}</span>
                                <span class="mt-0.5 block truncate text-xs text-stone-400">
                                    {{ $cita->motivo ?: 'Consulta' }}
                                    @if ($cita->medico)
                                        · {{ $cita->medico->nombre }}
                                    @endif
                                </span>
                            </span>
                            <x-estado-badge :estado="$cita->estado" />
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <div class="space-y-6">
            <section class="card p-6">
                <h3 class="font-display text-xl text-sage-900">Accesos rápidos</h3>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <a href="{{ route('panel.consultas.create') }}" class="rounded-2xl border border-stone-200/70 bg-cream-50 p-4 transition hover:border-sage-300 hover:bg-sage-50">
                        <x-icon name="stethoscope" class="size-5 text-sage-600" />
                        <span class="mt-3 block text-sm font-medium text-stone-700">Nueva consulta</span>
                    </a>
                    <a href="{{ route('panel.recetas.create') }}" class="rounded-2xl border border-stone-200/70 bg-cream-50 p-4 transition hover:border-sage-300 hover:bg-sage-50">
                        <x-icon name="pill" class="size-5 text-sage-600" />
                        <span class="mt-3 block text-sm font-medium text-stone-700">Nueva receta</span>
                    </a>
                    <a href="{{ route('panel.estudios.create') }}" class="rounded-2xl border border-stone-200/70 bg-cream-50 p-4 transition hover:border-sage-300 hover:bg-sage-50">
                        <x-icon name="folder" class="size-5 text-sage-600" />
                        <span class="mt-3 block text-sm font-medium text-stone-700">Subir estudio</span>
                    </a>
                    <a href="{{ route('panel.citas.index') }}" class="rounded-2xl border border-stone-200/70 bg-cream-50 p-4 transition hover:border-sage-300 hover:bg-sage-50">
                        <x-icon name="calendar" class="size-5 text-sage-600" />
                        <span class="mt-3 block text-sm font-medium text-stone-700">Ver agenda</span>
                    </a>
                </div>
            </section>

            <section class="card p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-xl text-sage-900">Pacientes recientes</h3>
                    <a href="{{ route('panel.pacientes.index') }}" class="text-xs font-medium text-sage-600 hover:text-sage-800">Ver todos</a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($pacientesRecientes as $paciente)
                        <a href="{{ route('panel.pacientes.show', $paciente) }}" class="flex items-center gap-3 rounded-xl p-2 transition hover:bg-cream-50">
                            <span class="grid size-9 shrink-0 place-items-center rounded-full bg-sage-100 text-xs font-semibold text-sage-700">
                                {{ $paciente->iniciales }}
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-medium text-stone-700">{{ $paciente->nombre }}</span>
                                <span class="block text-xs text-stone-400">{{ $paciente->edad }} años · {{ $paciente->telefono ?: 'Sin teléfono' }}</span>
                            </span>
                            <x-icon name="chevron-right" class="size-4 text-stone-300" />
                        </a>
                    @empty
                        <p class="py-4 text-sm text-stone-400">Aún no hay pacientes registrados.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <section class="card mt-6 overflow-hidden">
        <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-5">
            <div>
                <h3 class="font-display text-xl text-sage-900">Próximas citas</h3>
                <p class="mt-0.5 text-xs text-stone-400">Las siguientes en la agenda</p>
            </div>
            <a href="{{ route('panel.citas.index') }}" class="flex items-center gap-1.5 text-xs font-medium text-sage-600 hover:text-sage-800">
                Ver agenda
                <x-icon name="arrow-right" class="size-3.5" />
            </a>
        </div>

        @if ($proximasCitas->isEmpty())
            <x-empty-state icon="calendar" title="Sin citas próximas" description="Agenda una nueva cita para comenzar." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[680px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Fecha</th>
                            <th class="table-head">Paciente</th>
                            <th class="table-head">Médico</th>
                            <th class="table-head">Motivo</th>
                            <th class="table-head">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($proximasCitas as $cita)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell whitespace-nowrap">
                                    <span class="font-medium text-stone-700">{{ $cita->fecha->translatedFormat('D d M') }}</span>
                                    <span class="block text-xs text-stone-400">{{ $cita->fecha->format('H:i') }} hrs</span>
                                </td>
                                <td class="table-cell">
                                    <a href="{{ route('panel.pacientes.show', $cita->paciente) }}" class="font-medium text-stone-700 hover:text-sage-700">
                                        {{ $cita->paciente?->nombre }}
                                    </a>
                                </td>
                                <td class="table-cell">{{ $cita->medico?->nombre ?? 'Sin asignar' }}</td>
                                <td class="table-cell">{{ $cita->motivo ?: '—' }}</td>
                                <td class="table-cell"><x-estado-badge :estado="$cita->estado" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
