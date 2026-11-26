@extends('layouts.app')

@section('title', 'Expediente del paciente')
@section('titulo', 'Expediente')
@section('subtitulo', 'Historial clínico y datos del paciente')

@section('content')
    <div class="card overflow-hidden">
        <div class="flex flex-col gap-6 p-6 sm:p-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-5">
                <span class="grid size-16 shrink-0 place-items-center rounded-3xl bg-sage-100 font-display text-2xl text-sage-700">
                    {{ $paciente->iniciales }}
                </span>
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="font-display text-2xl text-sage-900">{{ $paciente->nombre }}</h2>
                        @if ($paciente->activo)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-sage-50 px-2.5 py-1 text-xs font-medium text-sage-700 ring-1 ring-inset ring-sage-200">
                                <span class="size-1.5 rounded-full bg-sage-500"></span> Activo
                            </span>
                        @else
                            <span class="rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-500">Inactivo</span>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-stone-500">
                        {{ $paciente->edad }} años · {{ $paciente->sexo === 'F' ? 'Femenino' : 'Masculino' }}
                        @if ($paciente->fecha_nacimiento)
                            · Nacimiento {{ $paciente->fecha_nacimiento->translatedFormat('d M Y') }}
                        @endif
                    </p>
                    <p class="mt-1 text-xs text-stone-400">Registrado el {{ $paciente->fecha_registro?->translatedFormat('d M Y') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('panel.pacientes.edit', $paciente) }}" class="btn-soft px-4 py-2.5">
                    <x-icon name="edit" class="size-4" />
                    Editar
                </a>
                <a href="{{ route('panel.citas.create', ['paciente' => $paciente->id_paciente]) }}" class="btn-primary px-4 py-2.5">
                    <x-icon name="calendar" class="size-4" />
                    Nueva cita
                </a>
                @if (auth()->user()->esAdmin() || auth()->user()->esMedico())
                    <a href="{{ route('panel.consultas.create', ['paciente' => $paciente->id_paciente]) }}" class="btn-soft px-4 py-2.5">
                        <x-icon name="stethoscope" class="size-4" />
                        Nueva consulta
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[0.85fr_1.15fr]">
        <div class="space-y-6">
            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Información de contacto</h3>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <x-icon name="phone" class="mt-0.5 size-4 text-sage-500" />
                        <div>
                            <dt class="text-xs text-stone-400">Teléfono</dt>
                            <dd class="text-stone-700">{{ $paciente->telefono ?: 'Sin registrar' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-icon name="mail" class="mt-0.5 size-4 text-sage-500" />
                        <div>
                            <dt class="text-xs text-stone-400">Correo</dt>
                            <dd class="break-all text-stone-700">{{ $paciente->email ?: 'Sin registrar' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-icon name="map-pin" class="mt-0.5 size-4 text-sage-500" />
                        <div>
                            <dt class="text-xs text-stone-400">Dirección</dt>
                            <dd class="text-stone-700">{{ $paciente->direccion ?: 'Sin registrar' }}</dd>
                        </div>
                    </div>
                </dl>
            </section>

            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Información clínica</h3>
                <div class="mt-4 space-y-4 text-sm">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Padecimiento actual</p>
                        <p class="mt-1 text-stone-700">{{ $paciente->padecimiento ?: 'Sin registrar' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Alergias</p>
                        <p class="mt-1 text-stone-700">{{ $paciente->alergias ?: 'Ninguna registrada' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Antecedentes</p>
                        <p class="mt-1 text-stone-700">{{ $paciente->antecedentes ?: 'Sin registrar' }}</p>
                    </div>
                </div>
            </section>

            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Médico tratante</h3>
                @if ($paciente->medico)
                    <div class="mt-4 flex items-center gap-3 rounded-2xl bg-cream-50 p-3">
                        <span class="grid size-10 place-items-center rounded-full bg-sage-100 text-sm font-semibold text-sage-700">
                            {{ mb_strtoupper(mb_substr($paciente->medico->nombre, 0, 1)) }}
                        </span>
                        <div>
                            <p class="text-sm font-medium text-stone-800">{{ $paciente->medico->nombre }}</p>
                            <p class="text-xs text-stone-400">{{ $paciente->medico->especialidad }}</p>
                        </div>
                    </div>
                @else
                    <p class="mt-3 text-sm text-stone-400">Aún no tiene un médico asignado.</p>
                @endif
            </section>
        </div>

        <div class="space-y-6">
            <section class="card overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-4">
                    <h3 class="font-display text-lg text-sage-900">Consultas recientes</h3>
                    <a href="{{ route('panel.consultas.index', ['q' => $paciente->nombre]) }}" class="text-xs font-medium text-sage-600 hover:text-sage-800">Ver historial</a>
                </div>

                @if ($paciente->consultas->isEmpty())
                    <p class="px-6 py-8 text-sm text-stone-400">Este paciente aún no tiene consultas registradas.</p>
                @else
                    <div class="divide-y divide-stone-100">
                        @foreach ($paciente->consultas as $consulta)
                            <a href="{{ route('panel.consultas.show', $consulta) }}" class="flex items-start gap-4 px-6 py-4 transition hover:bg-cream-50">
                                <span class="mt-0.5 grid size-9 shrink-0 place-items-center rounded-xl bg-sage-50 text-sage-600">
                                    <x-icon name="stethoscope" class="size-4" />
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="flex flex-wrap items-center justify-between gap-2">
                                        <span class="text-sm font-medium text-stone-800">{{ $consulta->diagnostico ?: 'Consulta médica' }}</span>
                                        <span class="text-xs text-stone-400">{{ $consulta->fecha->translatedFormat('d M Y') }}</span>
                                    </span>
                                    <span class="mt-0.5 block truncate text-xs text-stone-400">{{ $consulta->motivo }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="card overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-4">
                    <h3 class="font-display text-lg text-sage-900">Citas</h3>
                    <a href="{{ route('panel.citas.index') }}" class="text-xs font-medium text-sage-600 hover:text-sage-800">Ver agenda</a>
                </div>

                @if ($paciente->citas->isEmpty())
                    <p class="px-6 py-8 text-sm text-stone-400">No hay citas registradas para este paciente.</p>
                @else
                    <div class="divide-y divide-stone-100">
                        @foreach ($paciente->citas as $cita)
                            <a href="{{ route('panel.citas.show', $cita) }}" class="flex items-center justify-between gap-3 px-6 py-3.5 text-sm transition hover:bg-cream-50">
                                <span>
                                    <span class="block text-stone-700">{{ $cita->fecha->translatedFormat('D d M Y · H:i') }}</span>
                                    <span class="block text-xs text-stone-400">{{ $cita->motivo ?: 'Consulta' }}</span>
                                </span>
                                <x-estado-badge :estado="$cita->estado" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="card overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-4">
                    <h3 class="font-display text-lg text-sage-900">Estudios</h3>
                    <a href="{{ route('panel.estudios.create', ['paciente' => $paciente->id_paciente]) }}" class="text-xs font-medium text-sage-600 hover:text-sage-800">Subir estudio</a>
                </div>

                @if ($paciente->estudios->isEmpty())
                    <p class="px-6 py-8 text-sm text-stone-400">No hay estudios cargados.</p>
                @else
                    <div class="divide-y divide-stone-100">
                        @foreach ($paciente->estudios as $estudio)
                            <div class="flex items-center justify-between gap-3 px-6 py-3.5 text-sm">
                                <span class="flex min-w-0 items-center gap-3">
                                    <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-cream-100 text-clay-500">
                                        <x-icon name="file" class="size-4" />
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block truncate text-stone-700">{{ $estudio->nombre_archivo }}</span>
                                        <span class="block text-xs text-stone-400">{{ $estudio->tipo ?: 'Estudio' }} · {{ $estudio->fecha_subida->translatedFormat('d M Y') }}</span>
                                    </span>
                                </span>
                                <a href="{{ route('panel.estudios.descargar', $estudio) }}" class="grid size-8 shrink-0 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Descargar">
                                    <x-icon name="download" class="size-4" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
