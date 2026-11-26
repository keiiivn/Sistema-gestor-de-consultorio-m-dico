@extends('layouts.app')

@section('title', 'Detalle de la consulta')
@section('titulo', 'Detalle de la consulta')
@section('subtitulo', $consulta->paciente?->nombre)

@section('content')
    <div class="card p-6 sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <span class="grid size-14 place-items-center rounded-2xl bg-sage-50 text-sage-600">
                    <x-icon name="stethoscope" class="size-6" />
                </span>
                <div>
                    <h2 class="font-display text-2xl text-sage-900">{{ $consulta->diagnostico ?: 'Consulta médica' }}</h2>
                    <p class="mt-1 text-sm text-stone-500">
                        {{ $consulta->fecha->translatedFormat('l d \d\e F \d\e Y') }} · {{ $consulta->fecha->format('H:i') }} hrs
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('panel.consultas.edit', $consulta) }}" class="btn-soft px-4 py-2.5">
                    <x-icon name="edit" class="size-4" />
                    Editar
                </a>
                <a href="{{ route('panel.recetas.create', ['consulta' => $consulta->id_consulta]) }}" class="btn-primary px-4 py-2.5">
                    <x-icon name="pill" class="size-4" />
                    Nueva receta
                </a>
                <a href="{{ route('panel.estudios.create', ['paciente' => $consulta->id_paciente]) }}" class="btn-soft px-4 py-2.5">
                    <x-icon name="folder" class="size-4" />
                    Subir estudio
                </a>
            </div>
        </div>

        <div class="mt-8 grid gap-4 rounded-2xl bg-cream-50 p-5 sm:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Paciente</p>
                <a href="{{ route('panel.pacientes.show', $consulta->paciente) }}" class="mt-1 block text-sm font-medium text-sage-800 hover:text-sage-600">
                    {{ $consulta->paciente?->nombre }}
                </a>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Médico</p>
                <p class="mt-1 text-sm text-stone-700">{{ $consulta->medico?->nombre ?? 'Sin asignar' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Cita relacionada</p>
                @if ($consulta->cita)
                    <a href="{{ route('panel.citas.show', $consulta->cita) }}" class="mt-1 block text-sm text-sage-700 hover:text-sage-600">
                        {{ $consulta->cita->fecha->translatedFormat('d M Y · H:i') }}
                    </a>
                @else
                    <p class="mt-1 text-sm text-stone-400">Sin cita relacionada</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        @php
            $secciones = [
                ['titulo' => 'Motivo de la consulta', 'valor' => $consulta->motivo],
                ['titulo' => 'Antecedentes', 'valor' => $consulta->antecedentes],
                ['titulo' => 'Signos vitales', 'valor' => $consulta->signos_vitales],
                ['titulo' => 'Revisión física', 'valor' => $consulta->revision_fisica],
                ['titulo' => 'Diagnóstico', 'valor' => $consulta->diagnostico],
                ['titulo' => 'Tratamiento', 'valor' => $consulta->tratamiento],
                ['titulo' => 'Resultados', 'valor' => $consulta->resultados],
                ['titulo' => 'Notas internas', 'valor' => $consulta->notas],
            ];
        @endphp

        @foreach ($secciones as $seccion)
            <section class="card p-6">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-sage-600">{{ $seccion['titulo'] }}</h3>
                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-stone-600">{{ $seccion['valor'] ?: 'Sin registrar.' }}</p>
            </section>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-4">
                <h3 class="font-display text-lg text-sage-900">Recetas de esta consulta</h3>
                <a href="{{ route('panel.recetas.create', ['consulta' => $consulta->id_consulta]) }}" class="text-xs font-medium text-sage-600 hover:text-sage-800">Nueva receta</a>
            </div>

            @if ($consulta->recetas->isEmpty())
                <p class="px-6 py-8 text-sm text-stone-400">Aún no hay recetas para esta consulta.</p>
            @else
                <div class="divide-y divide-stone-100">
                    @foreach ($consulta->recetas as $receta)
                        <a href="{{ route('panel.recetas.show', $receta) }}" class="flex items-center justify-between gap-3 px-6 py-4 text-sm transition hover:bg-cream-50">
                            <span>
                                <span class="block font-medium text-stone-700">Receta #{{ $receta->id_receta }}</span>
                                <span class="block text-xs text-stone-400">{{ $receta->medicamentos->count() }} medicamentos · {{ $receta->fecha_registro->translatedFormat('d M Y') }}</span>
                            </span>
                            <x-icon name="chevron-right" class="size-4 text-stone-300" />
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-stone-100 px-6 py-4">
                <h3 class="font-display text-lg text-sage-900">Estudios relacionados</h3>
                <a href="{{ route('panel.estudios.create', ['paciente' => $consulta->id_paciente]) }}" class="text-xs font-medium text-sage-600 hover:text-sage-800">Subir estudio</a>
            </div>

            @if ($consulta->estudios->isEmpty())
                <p class="px-6 py-8 text-sm text-stone-400">No hay estudios vinculados a esta consulta.</p>
            @else
                <div class="divide-y divide-stone-100">
                    @foreach ($consulta->estudios as $estudio)
                        <div class="flex items-center justify-between gap-3 px-6 py-4 text-sm">
                            <span class="flex min-w-0 items-center gap-3">
                                <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-cream-100 text-clay-500">
                                    <x-icon name="file" class="size-4" />
                                </span>
                                <span class="min-w-0">
                                    <span class="block truncate text-stone-700">{{ $estudio->nombre_archivo }}</span>
                                    <span class="block text-xs text-stone-400">{{ $estudio->tipo ?: 'Estudio' }}</span>
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
@endsection
