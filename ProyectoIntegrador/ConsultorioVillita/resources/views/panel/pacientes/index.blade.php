@extends('layouts.app')

@section('title', 'Pacientes')
@section('titulo', 'Pacientes')
@section('subtitulo', 'Expedientes y datos de contacto')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-2xl text-sage-900">Directorio de pacientes</h2>
            <p class="mt-1 text-sm text-stone-500">{{ $pacientes->total() }} pacientes registrados</p>
        </div>
        <a href="{{ route('panel.pacientes.create') }}" class="btn-primary px-5 py-2.5">
            <x-icon name="plus" class="size-4" />
            Nuevo paciente
        </a>
    </div>

    <form method="GET" action="{{ route('panel.pacientes.index') }}" class="card mt-6 flex flex-col gap-3 p-4 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-stone-400" />
            <input
                type="search"
                name="q"
                value="{{ $buscar }}"
                placeholder="Buscar por nombre, teléfono o correo"
                class="input-base pl-10"
            >
        </div>

        <div class="sm:w-56">
            <select name="medico" class="input-base cursor-pointer">
                <option value="">Todos los médicos</option>
                @foreach ($medicos as $medico)
                    <option value="{{ $medico->id_medico }}" @selected(request('medico') == $medico->id_medico)>
                        {{ $medico->nombre }} · {{ $medico->especialidad }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="btn-primary px-5 py-2.5">Filtrar</button>
            @if (request()->filled('q') || request()->filled('medico'))
                <a href="{{ route('panel.pacientes.index') }}" class="btn-ghost">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="card mt-6 overflow-hidden">
        @if ($pacientes->isEmpty())
            <x-empty-state icon="users" title="No encontramos pacientes" description="Ajusta la búsqueda o registra un nuevo paciente para comenzar.">
                <x-slot:accion>
                    <a href="{{ route('panel.pacientes.create') }}" class="btn-primary px-5 py-2.5">Registrar paciente</a>
                </x-slot:accion>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px]">
                    <thead class="border-b border-stone-100 bg-cream-50/60">
                        <tr>
                            <th class="table-head">Paciente</th>
                            <th class="table-head">Contacto</th>
                            <th class="table-head">Médico tratante</th>
                            <th class="table-head">Última consulta</th>
                            <th class="table-head">Estado</th>
                            <th class="table-head text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($pacientes as $paciente)
                            <tr class="transition hover:bg-cream-50/60">
                                <td class="table-cell">
                                    <a href="{{ route('panel.pacientes.show', $paciente) }}" class="flex items-center gap-3">
                                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-sage-100 text-xs font-semibold text-sage-700">
                                            {{ $paciente->iniciales }}
                                        </span>
                                        <span>
                                            <span class="block font-medium text-stone-800">{{ $paciente->nombre }}</span>
                                            <span class="block text-xs text-stone-400">{{ $paciente->edad }} años · {{ $paciente->sexo === 'F' ? 'Femenino' : 'Masculino' }}</span>
                                        </span>
                                    </a>
                                </td>
                                <td class="table-cell">
                                    <span class="block">{{ $paciente->telefono ?: '—' }}</span>
                                    <span class="block text-xs text-stone-400">{{ $paciente->email ?: 'Sin correo' }}</span>
                                </td>
                                <td class="table-cell">
                                    @if ($paciente->medico)
                                        <span class="block text-stone-700">{{ $paciente->medico->nombre }}</span>
                                        <span class="block text-xs text-stone-400">{{ $paciente->medico->especialidad }}</span>
                                    @else
                                        <span class="text-stone-400">Sin asignar</span>
                                    @endif
                                </td>
                                <td class="table-cell whitespace-nowrap">
                                    {{ $paciente->ultima_consulta ? $paciente->ultima_consulta->translatedFormat('d M Y') : '—' }}
                                </td>
                                <td class="table-cell">
                                    @if ($paciente->activo)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sage-50 px-2.5 py-1 text-xs font-medium text-sage-700 ring-1 ring-inset ring-sage-200">
                                            <span class="size-1.5 rounded-full bg-sage-500"></span> Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-500 ring-1 ring-inset ring-stone-200">
                                            <span class="size-1.5 rounded-full bg-stone-400"></span> Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('panel.pacientes.show', $paciente) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Ver expediente">
                                            <x-icon name="eye" class="size-4" />
                                        </a>
                                        <a href="{{ route('panel.pacientes.edit', $paciente) }}" class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-sage-50 hover:text-sage-700" title="Editar">
                                            <x-icon name="edit" class="size-4" />
                                        </a>
                                        @if (auth()->user()->esAdmin())
                                            <form method="POST" action="{{ route('panel.pacientes.destroy', $paciente) }}" data-confirm="¿Eliminar a {{ $paciente->nombre }}? Se borrarán sus citas, consultas y estudios.">
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
                {{ $pacientes->links() }}
            </div>
        @endif
    </div>
@endsection
