@extends('layouts.app')

@section('title', 'Detalle de la receta')
@section('titulo', 'Detalle de la receta')
@section('subtitulo', 'Folio #'.str_pad((string) $receta->id_receta, 4, '0', STR_PAD_LEFT))

@section('content')
    <div class="card p-6 sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="eyebrow">Receta médica</p>
                <h2 class="mt-3 font-display text-3xl tracking-tight text-sage-900">
                    Folio #{{ str_pad((string) $receta->id_receta, 4, '0', STR_PAD_LEFT) }}
                </h2>
                <p class="mt-2 text-sm text-stone-500">
                    Emitida el {{ $receta->fecha_registro?->translatedFormat('l d \d\e F \d\e Y') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('panel.recetas.imprimir', $receta) }}" target="_blank" class="btn-primary px-4 py-2.5">
                    <x-icon name="print" class="size-4" />
                    Imprimir
                </a>
                <a href="{{ route('panel.recetas.edit', $receta) }}" class="btn-soft px-4 py-2.5">
                    <x-icon name="edit" class="size-4" />
                    Editar
                </a>
                <form method="POST" action="{{ route('panel.recetas.destroy', $receta) }}" data-confirm="¿Eliminar esta receta?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-ghost px-4 py-2.5 text-rose-600 hover:bg-rose-50">
                        <x-icon name="trash" class="size-4" />
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-8 grid gap-4 rounded-2xl bg-cream-50 p-5 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Paciente</p>
                <p class="mt-1 text-sm font-medium text-stone-800">{{ $receta->nombre_paciente ?: $receta->consulta?->paciente?->nombre }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Edad</p>
                <p class="mt-1 text-sm text-stone-700">{{ $receta->edad ? $receta->edad.' años' : '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Altura</p>
                <p class="mt-1 text-sm text-stone-700">{{ $receta->altura ? $receta->altura.' m' : '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Peso</p>
                <p class="mt-1 text-sm text-stone-700">{{ $receta->peso ? $receta->peso.' kg' : '—' }}</p>
            </div>
        </div>

        @if ($receta->consulta)
            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-stone-500">
                <span class="flex items-center gap-2">
                    <x-icon name="stethoscope" class="size-4 text-sage-500" />
                    <a href="{{ route('panel.consultas.show', $receta->consulta) }}" class="hover:text-sage-700">
                        Consulta del {{ $receta->consulta->fecha->translatedFormat('d M Y') }}
                    </a>
                </span>
                <span class="flex items-center gap-2">
                    <x-icon name="user" class="size-4 text-sage-500" />
                    {{ $receta->consulta->medico?->nombre ?? 'Médico sin asignar' }}
                </span>
            </div>
        @endif
    </div>

    <div class="card mt-6 overflow-hidden">
        <div class="border-b border-stone-100 px-6 py-4">
            <h3 class="font-display text-lg text-sage-900">Medicamentos</h3>
        </div>

        @if ($receta->medicamentos->isEmpty())
            <p class="px-6 py-8 text-sm text-stone-400">Esta receta no tiene medicamentos registrados.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Medicamento</th>
                            <th class="table-head">Dosis</th>
                            <th class="table-head">Frecuencia</th>
                            <th class="table-head">Duración</th>
                            <th class="table-head">Vía</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($receta->medicamentos as $medicamento)
                            <tr>
                                <td class="table-cell">
                                    <span class="block font-medium text-stone-800">{{ $medicamento->medicamento }}</span>
                                    <span class="block text-xs text-stone-400">{{ $medicamento->presentacion }}</span>
                                    @if ($medicamento->indicaciones)
                                        <span class="mt-1 block text-xs text-stone-400">{{ $medicamento->indicaciones }}</span>
                                    @endif
                                </td>
                                <td class="table-cell">{{ $medicamento->dosis ?: '—' }}</td>
                                <td class="table-cell">{{ $medicamento->frecuencia ?: '—' }}</td>
                                <td class="table-cell">{{ $medicamento->duracion ?: '—' }}</td>
                                <td class="table-cell">{{ $medicamento->via_administracion ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if ($receta->indicaciones)
        <div class="card mt-6 p-6">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-sage-600">Indicaciones generales</h3>
            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-stone-600">{{ $receta->indicaciones }}</p>
        </div>
    @endif
@endsection
