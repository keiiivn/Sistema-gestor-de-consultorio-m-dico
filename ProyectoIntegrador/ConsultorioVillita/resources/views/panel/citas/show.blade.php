@extends('layouts.app')

@section('title', 'Detalle de la cita')
@section('titulo', 'Detalle de la cita')
@section('subtitulo', $cita->paciente?->nombre)

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="card p-6 sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <span class="grid size-14 place-items-center rounded-2xl bg-sage-50 text-sage-600">
                        <x-icon name="calendar" class="size-6" />
                    </span>
                    <div>
                        <h2 class="font-display text-2xl text-sage-900">{{ $cita->fecha->translatedFormat('l d \d\e F') }}</h2>
                        <p class="mt-1 text-sm text-stone-500">{{ $cita->fecha->format('H:i') }} hrs · {{ $cita->duracion_minutos }} minutos</p>
                    </div>
                </div>
                <x-estado-badge :estado="$cita->estado" />
            </div>

            <dl class="mt-8 grid gap-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-stone-400">Paciente</dt>
                    <dd class="mt-1">
                        <a href="{{ route('panel.pacientes.show', $cita->paciente) }}" class="font-medium text-sage-800 hover:text-sage-600">
                            {{ $cita->paciente?->nombre }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-stone-400">Médico</dt>
                    <dd class="mt-1 text-stone-700">{{ $cita->medico?->nombre ?? 'Sin asignar' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-stone-400">Motivo</dt>
                    <dd class="mt-1 text-stone-700">{{ $cita->motivo ?: 'Consulta general' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-stone-400">Registrada</dt>
                    <dd class="mt-1 text-stone-700">{{ $cita->created_at?->translatedFormat('d M Y · H:i') }}</dd>
                </div>
            </dl>

            @if ($cita->observaciones)
                <div class="mt-6 rounded-2xl bg-cream-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-stone-400">Observaciones</p>
                    <p class="mt-1.5 whitespace-pre-line text-sm leading-relaxed text-stone-600">{{ $cita->observaciones }}</p>
                </div>
            @endif

            <div class="mt-8 flex flex-wrap gap-2">
                <a href="{{ route('panel.citas.edit', $cita) }}" class="btn-soft px-5 py-2.5">
                    <x-icon name="edit" class="size-4" />
                    Editar cita
                </a>
                @if (in_array(auth()->user()->rol, ['admin', 'recepcionista'], true))
                    <form method="POST" action="{{ route('panel.citas.destroy', $cita) }}" data-confirm="¿Eliminar esta cita?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-ghost px-5 py-2.5 text-rose-600 hover:bg-rose-50">
                            <x-icon name="trash" class="size-4" />
                            Eliminar
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Actualizar estado</h3>
                <p class="mt-1 text-xs text-stone-400">Mantén la agenda al día.</p>

                <form method="POST" action="{{ route('panel.citas.estado', $cita) }}" class="mt-4 flex gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="estado" class="input-base cursor-pointer">
                        @foreach (['pendiente', 'confirmada', 'cancelada', 'atendida'] as $estado)
                            <option value="{{ $estado }}" @selected($cita->estado === $estado)>{{ ucfirst($estado) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-primary px-5 py-2.5">Guardar</button>
                </form>
            </section>

            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Atención médica</h3>

                @if ($cita->consulta)
                    <p class="mt-2 text-sm text-stone-500">Esta cita ya tiene una consulta registrada.</p>
                    <a href="{{ route('panel.consultas.show', $cita->consulta) }}" class="btn-soft mt-4 w-full px-5 py-2.5">
                        <x-icon name="stethoscope" class="size-4" />
                        Ver consulta
                    </a>
                @elseif (auth()->user()->esAdmin() || auth()->user()->esMedico())
                    <p class="mt-2 text-sm text-stone-500">Registra la consulta cuando el paciente haya sido atendido.</p>
                    <a href="{{ route('panel.consultas.create', ['paciente' => $cita->id_paciente, 'cita' => $cita->id_cita]) }}" class="btn-primary mt-4 w-full px-5 py-2.5">
                        <x-icon name="stethoscope" class="size-4" />
                        Registrar consulta
                    </a>
                @else
                    <p class="mt-2 text-sm text-stone-500">La consulta será registrada por el médico asignado.</p>
                @endif
            </section>

            <section class="card p-6">
                <h3 class="font-display text-lg text-sage-900">Paciente</h3>
                <div class="mt-4 flex items-center gap-3">
                    <span class="grid size-11 place-items-center rounded-full bg-sage-100 text-sm font-semibold text-sage-700">
                        {{ $cita->paciente?->iniciales }}
                    </span>
                    <div>
                        <p class="text-sm font-medium text-stone-800">{{ $cita->paciente?->nombre }}</p>
                        <p class="text-xs text-stone-400">{{ $cita->paciente?->edad }} años · {{ $cita->paciente?->telefono ?: 'Sin teléfono' }}</p>
                    </div>
                </div>
                <a href="{{ route('panel.pacientes.show', $cita->paciente) }}" class="mt-4 flex items-center gap-1.5 text-xs font-medium text-sage-600 hover:text-sage-800">
                    Abrir expediente
                    <x-icon name="arrow-right" class="size-3.5" />
                </a>
            </section>
        </div>
    </div>
@endsection
