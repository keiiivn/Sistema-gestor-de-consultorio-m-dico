@extends('layouts.app')

@section('title', 'Estudios')
@section('titulo', 'Estudios')
@section('subtitulo', 'Documentos y archivos clínicos')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-2xl text-sage-900">Estudios y documentos</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $estudios->total() }} archivos resguardados</p>
        </div>
        <a href="{{ route('panel.estudios.create') }}" class="btn-primary px-5 py-2.5">
            <x-icon name="plus" class="size-4" />
            Subir estudio
        </a>
    </div>

    <form method="GET" action="{{ route('panel.estudios.index') }}" class="card mt-6 flex flex-col gap-3 p-4 lg:flex-row lg:items-center">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-stone-400" />
            <input type="search" name="q" value="{{ $buscar }}" placeholder="Buscar por archivo o paciente" class="input-base pl-10">
        </div>
        <div class="lg:w-52">
            <select name="tipo" class="input-base cursor-pointer">
                <option value="">Todos los tipos</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo }}" @selected(request('tipo') === $tipo)>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary px-5 py-2.5">Filtrar</button>
            @if (request()->filled('q') || request()->filled('tipo'))
                <a href="{{ route('panel.estudios.index') }}" class="btn-ghost">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card mt-6 overflow-hidden">
        @if ($estudios->isEmpty())
            <x-empty-state icon="folder" title="No hay estudios cargados" description="Sube análisis, radiografías o documentos para mantener el expediente completo.">
                <x-slot:accion>
                    <a href="{{ route('panel.estudios.create') }}" class="btn-primary px-5 py-2.5">Subir estudio</a>
                </x-slot:accion>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[840px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Archivo</th>
                            <th class="table-head">Paciente</th>
                            <th class="table-head">Consulta</th>
                            <th class="table-head">Tipo</th>
                            <th class="table-head">Fecha</th>
                            <th class="table-head text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($estudios as $estudio)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell">
                                    <a href="{{ route('panel.estudios.show', $estudio) }}" class="flex items-center gap-3">
                                        <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-cream-100 text-clay-500">
                                            <x-icon name="file" class="size-4" />
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block max-w-[220px] truncate font-medium text-stone-700">{{ $estudio->nombre_archivo }}</span>
                                            <span class="block text-xs text-stone-400">{{ $estudio->descripcion ?: 'Sin descripción' }}</span>
                                        </span>
                                    </a>
                                </td>
                                <td class="table-cell">
                                    <a href="{{ route('panel.pacientes.show', $estudio->paciente) }}" class="text-stone-700 hover:text-sage-700">
                                        {{ $estudio->paciente?->nombre }}
                                    </a>
                                </td>
                                <td class="table-cell">
                                    @if ($estudio->consulta)
                                        <a href="{{ route('panel.consultas.show', $estudio->consulta) }}" class="text-stone-600 hover:text-sage-700">
                                            {{ $estudio->consulta->fecha->translatedFormat('d M Y') }}
                                        </a>
                                    @else
                                        <span class="text-stone-400">—</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <span class="rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-600">{{ $estudio->tipo ?: 'Otro' }}</span>
                                </td>
                                <td class="table-cell whitespace-nowrap">{{ $estudio->fecha_subida->translatedFormat('d M Y') }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('panel.estudios.show', $estudio) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Ver estudio">
                                            <x-icon name="eye" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.estudios.descargar', $estudio) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Descargar">
                                            <x-icon name="download" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.estudios.edit', $estudio) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Editar">
                                            <x-icon name="edit" class="size-4" />
                                        </a>
                                        <form method="POST" action="{{ route('panel.estudios.destroy', $estudio) }}" data-confirm="¿Eliminar este estudio? El archivo se borrará del servidor.">
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
                {{ $estudios->links() }}
            </div>
        @endif
    </div>
@endsection
