@extends('layouts.app')

@section('title', 'Detalle del estudio')
@section('titulo', 'Detalle del estudio')
@section('subtitulo', $estudio->nombre_archivo)

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="card p-6 sm:p-8">
            <div class="flex items-start gap-4">
                <span class="grid size-14 shrink-0 place-items-center rounded-2xl bg-cream-100 text-clay-500">
                    <x-icon name="file" class="size-6" />
                </span>
                <div class="min-w-0">
                    <h2 class="break-words font-display text-2xl text-sage-900">{{ $estudio->nombre_archivo }}</h2>
                    <p class="mt-1 text-sm text-stone-500">{{ $estudio->tipo ?: 'Estudio' }} · {{ $estudio->fecha_subida->translatedFormat('d \d\e F \d\e Y · H:i') }}</p>
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-cream-50 p-5">
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Descripción</p>
                <p class="mt-1.5 whitespace-pre-line text-sm leading-relaxed text-stone-600">{{ $estudio->descripcion ?: 'Sin descripción.' }}</p>
            </div>

            <div class="mt-6 flex flex-wrap gap-2">
                <a href="{{ route('panel.estudios.descargar', $estudio) }}" class="btn-primary px-5 py-2.5">
                    <x-icon name="download" class="size-4" />
                    Descargar archivo
                </a>
                <a href="{{ route('panel.estudios.edit', $estudio) }}" class="btn-soft px-5 py-2.5">
                    <x-icon name="edit" class="size-4" />
                    Editar
                </a>
                <form method="POST" action="{{ route('panel.estudios.destroy', $estudio) }}" data-confirm="¿Eliminar este estudio? El archivo se borrará del servidor.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-ghost px-5 py-2.5 text-rose-600 hover:bg-rose-50">
                        <x-icon name="trash" class="size-4" />
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Paciente</h3>
                <div class="mt-4 flex items-center gap-3">
                    <span class="grid size-11 place-items-center rounded-full bg-sage-100 text-sm font-semibold text-sage-700">
                        {{ $estudio->paciente?->iniciales }}
                    </span>
                    <div>
                        <p class="text-sm font-medium text-stone-800">{{ $estudio->paciente?->nombre }}</p>
                        <p class="text-xs text-stone-400">{{ $estudio->paciente?->edad }} años · {{ $estudio->paciente?->telefono ?: 'Sin teléfono' }}</p>
                    </div>
                </div>
                <a href="{{ route('panel.pacientes.show', $estudio->paciente) }}" class="mt-4 flex items-center gap-1.5 text-xs font-medium text-sage-600 hover:text-sage-800">
                    Abrir expediente
                    <x-icon name="arrow-right" class="size-3.5" />
                </a>
            </section>

            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Consulta relacionada</h3>
                @if ($estudio->consulta)
                    <p class="mt-2 text-sm text-stone-500">{{ $estudio->consulta->diagnostico ?: 'Consulta médica' }}</p>
                    <p class="text-xs text-stone-400">{{ $estudio->consulta->fecha->translatedFormat('d M Y') }}</p>
                    <a href="{{ route('panel.consultas.show', $estudio->consulta) }}" class="mt-4 flex items-center gap-1.5 text-xs font-medium text-sage-600 hover:text-sage-800">
                        Ver consulta
                        <x-icon name="arrow-right" class="size-3.5" />
                    </a>
                @else
                    <p class="mt-2 text-sm text-stone-400">Este estudio no está vinculado a una consulta.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
