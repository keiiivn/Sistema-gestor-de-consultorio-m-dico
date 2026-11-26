@php($paciente = $paciente ?? null)

<div class="card p-6 sm:p-8">
    <div class="flex items-center gap-3">
        <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
            <x-icon name="user" class="size-5" />
        </span>
        <div>
            <h2 class="font-display text-xl text-sage-900">Datos personales</h2>
            <p class="text-xs text-stone-400">Información básica para identificar al paciente</p>
        </div>
    </div>

    <div class="mt-6 grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <x-form.input name="nombre" label="Nombre completo" :value="$paciente?->nombre" required placeholder="Nombre y apellidos" />
        </div>

        <x-form.input
            name="fecha_nacimiento"
            label="Fecha de nacimiento"
            type="date"
            :value="$paciente?->fecha_nacimiento?->format('Y-m-d')"
            required
        />

        <x-form.select name="sexo" label="Sexo" required>
            <option value="">Selecciona una opción</option>
            <option value="F" @selected(old('sexo', $paciente?->sexo) === 'F')>Femenino</option>
            <option value="M" @selected(old('sexo', $paciente?->sexo) === 'M')>Masculino</option>
        </x-form.select>

        <x-form.input name="telefono" label="Teléfono" :value="$paciente?->telefono" placeholder="55 1234 5678" />
        <x-form.input name="email" label="Correo electrónico" type="email" :value="$paciente?->email" placeholder="paciente@correo.com" />
        <div class="sm:col-span-2">
            <x-form.input name="direccion" label="Dirección" :value="$paciente?->direccion" placeholder="Calle, número, colonia" />
        </div>
    </div>
</div>

<div class="card mt-6 p-6 sm:p-8">
    <div class="flex items-center gap-3">
        <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
            <x-icon name="clipboard" class="size-5" />
        </span>
        <div>
            <h2 class="font-display text-xl text-sage-900">Información clínica</h2>
            <p class="text-xs text-stone-400">Datos relevantes para la atención médica</p>
        </div>
    </div>

    <div class="mt-6 grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <x-form.input name="padecimiento" label="Padecimiento actual" :value="$paciente?->padecimiento" placeholder="Motivo principal de la visita" />
        </div>

        <x-form.textarea name="alergias" label="Alergias" :value="$paciente?->alergias" rows="3" placeholder="Medicamentos, alimentos u otras alergias" />
        <x-form.textarea name="antecedentes" label="Antecedentes" :value="$paciente?->antecedentes" rows="3" placeholder="Antecedentes médicos relevantes" />

        <x-form.select name="id_medico" label="Médico tratante">
            <option value="">Sin asignar</option>
            @foreach ($medicos as $medico)
                <option value="{{ $medico->id_medico }}" @selected(old('id_medico', $paciente?->id_medico) == $medico->id_medico)>
                    {{ $medico->nombre }} · {{ $medico->especialidad }}
                </option>
            @endforeach
        </x-form.select>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-2.5 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm text-stone-600">
                <input type="checkbox" name="activo" value="1" @checked(old('activo', $paciente?->activo ?? true)) class="size-4 rounded border-stone-300 text-sage-600 focus:ring-sage-400">
                Paciente activo
            </label>
        </div>
    </div>
</div>
