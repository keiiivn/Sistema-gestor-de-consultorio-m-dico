@extends('layouts.app')

@section('title', 'Perfil del médico')
@section('titulo', 'Perfil del médico')
@section('subtitulo', $medico->nombre)

@section('content')
    <div class="card p-6 sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-5">
                <span class="grid size-16 place-items-center rounded-3xl bg-sage-100 font-display text-2xl text-sage-700">
                    {{ mb_strtoupper(mb_substr($medico->nombre, 0, 1)) }}
                </span>
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="font-display text-2xl text-sage-900">{{ $medico->nombre }}</h2>
                        @if ($medico->activo)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-sage-50 px-2.5 py-1 text-xs font-medium text-sage-700 ring-1 ring-inset ring-sage-200">
                                <span class="size-1.5 rounded-full bg-sage-500"></span> Activo
                            </span>
                        @else
                            <span class="rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-500">Inactivo</span>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-stone-500">{{ $medico->especialidad ?: 'Sin especialidad' }} · Cédula {{ $medico->cedula }}</p>
                    @if ($medico->usuario)
                        <p class="mt-1 text-xs text-stone-400">Usuario: {{ $medico->usuario->usuario }} · {{ $medico->usuario->email }}</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('panel.medicos.edit', $medico) }}" class="btn-soft px-4 py-2.5">
                    <x-icon name="edit" class="size-4" />
                    Editar
                </a>
                <form method="POST" action="{{ route('panel.medicos.destroy', $medico) }}" data-confirm="¿Eliminar el perfil de {{ $medico->nombre }}?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-ghost px-4 py-2.5 text-rose-600 hover:bg-rose-50">
                        <x-icon name="trash" class="size-4" />
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        @if ($medico->biografia)
            <p class="mt-6 max-w-3xl text-sm leading-relaxed text-stone-600">{{ $medico->biografia }}</p>
        @endif
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <x-stat-card label="Pacientes asignados" :value="$medico->pacientes_count" icon="users" tone="sage" />
        <x-stat-card label="Citas registradas" :value="$medico->citas_count" icon="calendar" tone="cream" />
        <x-stat-card label="Consultas realizadas" :value="$medico->consultas_count" icon="stethoscope" tone="stone" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_0.8fr]">
        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-4">
                <h3 class="font-display text-lg text-sage-900">Citas recientes</h3>
                <a href="{{ route('panel.citas.index') }}" class="text-xs font-medium text-sage-600 hover:text-sage-800">Ver agenda</a>
            </div>

            @if ($citas->isEmpty())
                <p class="px-6 py-8 text-sm text-stone-400">Este médico aún no tiene citas registradas.</p>
            @else
                <div class="divide-y divide-stone-100">
                    @foreach ($citas as $cita)
                        <a href="{{ route('panel.citas.show', $cita) }}" class="flex items-center justify-between gap-3 px-6 py-4 text-sm transition hover:bg-cream-50">
                            <span>
                                <span class="block text-stone-700">{{ $cita->paciente?->nombre }}</span>
                                <span class="block text-xs text-stone-400">{{ $cita->fecha->translatedFormat('d M Y · H:i') }}</span>
                            </span>
                            <x-estado-badge :estado="$cita->estado" />
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="card p-6">
            <h3 class="font-display text-lg text-sage-900">Datos de contacto</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex items-center gap-2.5">
                    <x-icon name="phone" class="size-4 text-sage-500" />
                    <dd class="text-stone-700">{{ $medico->telefono ?: 'Sin teléfono' }}</dd>
                </div>
                <div class="flex items-center gap-2.5">
                    <x-icon name="map-pin" class="size-4 text-sage-500" />
                    <dd class="text-stone-700">Consultorio {{ $medico->consultorio ?: '—' }}</dd>
                </div>
                @if ($medico->usuario)
                    <div class="flex items-center gap-2.5">
                        <x-icon name="mail" class="size-4 text-sage-500" />
                        <dd class="break-all text-stone-700">{{ $medico->usuario->email }}</dd>
                    </div>
                @endif
            </dl>
        </section>
    </div>
@endsection
