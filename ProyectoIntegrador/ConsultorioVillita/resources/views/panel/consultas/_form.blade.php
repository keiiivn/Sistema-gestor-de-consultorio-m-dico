@php
    $consulta = $consulta ?? null;
    $fecha = old('fecha', $consulta?->fecha?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i'));
    $pacienteSeleccionado = old('id_paciente', $consulta?->id_paciente ?? $idPaciente ?? request('paciente'));
@endphp

<div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
    <div class="space-y-6">
        <div class="card p-6 sm:p-8">
            <div class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                    <x-icon name="stethoscope" class="size-5" />
                </span>
                <div>
                    <h2 class="font-display text-xl text-sage-900">Datos generales</h2>
                    <p class="text-xs text-stone-400">Paciente y profesional de salud</p>
                </div>
            </div>

            <div class="mt-6 grid gap-5">
                <x-form.select name="id_paciente" label="Paciente" required>
                    <option value="">Selecciona un paciente</option>
                    @foreach ($pacientes as $paciente)
                        <option value="{{ $paciente->id_paciente }}" @selected($pacienteSeleccionado == $paciente->id_paciente)>
                            {{ $paciente->nombre }} · {{ $paciente->edad }} años
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.select name="id_medico" label="Médico">
                    <option value="">Sin asignar</option>
                    @foreach ($medicos as $medico)
                        <option value="{{ $medico->id_medico }}" @selected(old('id_medico', $consulta?->id_medico) == $medico->id_medico)>
                            {{ $medico->nombre }} · {{ $medico->especialidad }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.select name="id_cita" label="Cita relacionada" help="Opcional. Al vincular una cita se marcará como atendida.">
                    <option value="">Sin cita relacionada</option>
                    @foreach ($citas as $cita)
                        <option value="{{ $cita->id_cita }}" @selected(old('id_cita', $consulta?->id_cita ?? request('cita')) == $cita->id_cita)>
                            {{ $cita->fecha->translatedFormat('d M Y · H:i') }} · {{ $cita->paciente?->nombre }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.input name="fecha" label="Fecha y hora" type="datetime-local" :value="$fecha" required />
            </div>
        </div>

        <div class="card p-6 sm:p-8">
            <h2 class="font-display text-xl text-sage-900">Signos vitales y revisión</h2>
            <p class="mt-1 text-xs text-stone-400">Registra los valores obtenidos durante la consulta</p>

            <div class="mt-5 space-y-5">
                <x-form.textarea name="signos_vitales" label="Signos vitales" :value="$consulta?->signos_vitales" rows="3" placeholder="TA 120/80 mmHg · FC 72 lpm · Temp 36.5 °C · Peso 68 kg · Talla 1.70 m" />
                <x-form.textarea name="revision_fisica" label="Revisión física" :value="$consulta?->revision_fisica" rows="4" placeholder="Hallazgos de la exploración física" />
            </div>
        </div>
    </div>

    <div class="card p-6 sm:p-8">
        <h2 class="font-display text-xl text-sage-900">Nota clínica</h2>
        <p class="mt-1 text-xs text-stone-400">Motivo, diagnóstico y plan de tratamiento</p>

        <div class="mt-6 space-y-5">
            <x-form.textarea name="motivo" label="Motivo de la consulta" :value="$consulta?->motivo" rows="3" required placeholder="¿Por qué acude el paciente?" />
            <x-form.textarea name="antecedentes" label="Antecedentes" :value="$consulta?->antecedentes" rows="3" placeholder="Antecedentes relevantes para esta consulta" />
            <x-form.textarea name="diagnostico" label="Diagnóstico" :value="$consulta?->diagnostico" rows="3" placeholder="Diagnóstico o impresión diagnóstica" />
            <x-form.textarea name="tratamiento" label="Tratamiento" :value="$consulta?->tratamiento" rows="4" placeholder="Plan de tratamiento, indicaciones y recomendaciones" />
            <x-form.textarea name="resultados" label="Resultados" :value="$consulta?->resultados" rows="3" placeholder="Resultados de laboratorio o estudios" />
            <x-form.textarea name="notas" label="Notas internas" :value="$consulta?->notas" rows="3" placeholder="Notas adicionales para el equipo médico" />
        </div>
    </div>
</div>
