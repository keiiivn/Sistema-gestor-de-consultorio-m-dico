@php
    $cita = $cita ?? null;
    $fecha = old('fecha', $cita?->fecha?->format('Y-m-d\TH:i') ?? now()->addDay()->setTime(9, 0)->format('Y-m-d\TH:i'));
@endphp

<div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="calendar" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Datos de la cita</h2>
                <p class="text-xs text-stone-400">Paciente, horario y motivo</p>
            </div>
        </div>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-form.select name="id_paciente" label="Paciente" required>
                    <option value="">Selecciona un paciente</option>
                    @foreach ($pacientes as $paciente)
                        <option value="{{ $paciente->id_paciente }}" @selected(old('id_paciente', $cita?->id_paciente ?? request('paciente')) == $paciente->id_paciente)>
                            {{ $paciente->nombre }} · {{ $paciente->edad }} años
                        </option>
                    @endforeach
                </x-form.select>
            </div>

            <x-form.select name="id_medico" label="Médico">
                <option value="">Sin asignar</option>
                @foreach ($medicos as $medico)
                    <option value="{{ $medico->id_medico }}" @selected(old('id_medico', $cita?->id_medico) == $medico->id_medico)>
                        {{ $medico->nombre }} · {{ $medico->especialidad }}
                    </option>
                @endforeach
            </x-form.select>

            <x-form.select name="estado" label="Estado" required>
                @foreach ($estados as $estado)
                    <option value="{{ $estado }}" @selected(old('estado', $cita?->estado ?? 'pendiente') === $estado)>{{ ucfirst($estado) }}</option>
                @endforeach
            </x-form.select>

            <x-form.input name="fecha" label="Fecha y hora" type="datetime-local" :value="$fecha" required />
            <x-form.input name="duracion_minutos" label="Duración (minutos)" type="number" min="15" max="240" step="15" :value="$cita?->duracion_minutos ?? 30" required />

            <div class="sm:col-span-2">
                <x-form.input name="motivo" label="Motivo de la cita" :value="$cita?->motivo" placeholder="Consulta general, seguimiento, revisión..." />
            </div>
        </div>
    </div>

    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="clipboard" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Notas</h2>
                <p class="text-xs text-stone-400">Información adicional para el equipo</p>
            </div>
        </div>

        <div class="mt-6">
            <x-form.textarea name="observaciones" label="Observaciones" :value="$cita?->observaciones" rows="10" placeholder="Indicaciones, recordatorios o notas de recepción" />
        </div>

        <div class="mt-6 rounded-2xl bg-cream-50 p-4 text-xs leading-relaxed text-stone-500">
            <p class="flex items-center gap-2 font-medium text-sage-700">
                <x-icon name="clock" class="size-3.5" />
                Sugerencia
            </p>
            <p class="mt-1.5">Deja al menos 15 minutos entre citas para mantener una agenda cómoda y sin prisas.</p>
        </div>
    </div>
</div>
