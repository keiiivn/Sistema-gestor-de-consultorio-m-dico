@php($medico = $medico ?? null)

<div class="grid gap-6 lg:grid-cols-[1fr_1fr]">
    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="user" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Cuenta de acceso</h2>
                <p class="text-xs text-stone-400">Vincula el perfil con un usuario del sistema</p>
            </div>
        </div>

        <div class="mt-6 space-y-5">
            <x-form.select name="id_usuario" label="Usuario" help="Solo aparecen usuarios con rol médico sin perfil asignado.">
                <option value="">Sin usuario vinculado</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id_usuario }}" @selected(old('id_usuario', $medico?->id_usuario) == $usuario->id_usuario)>
                        {{ $usuario->nombre }} · {{ $usuario->usuario }}
                    </option>
                @endforeach
            </x-form.select>

            <x-form.input name="cedula" label="Cédula profesional" :value="$medico?->cedula" required placeholder="Número de cédula" />
            <x-form.input name="especialidad" label="Especialidad" :value="$medico?->especialidad" placeholder="Medicina general, pediatría..." />
            <x-form.input name="telefono" label="Teléfono" :value="$medico?->telefono" placeholder="55 1234 5678" />
            <x-form.input name="consultorio" label="Consultorio" :value="$medico?->consultorio" placeholder="1, 2, 3..." />

            <label class="inline-flex items-center gap-2.5 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm text-stone-600">
                <input type="checkbox" name="activo" value="1" @checked(old('activo', $medico?->activo ?? true)) class="size-4 rounded border-stone-300 text-sage-600 focus:ring-sage-400">
                Médico activo
            </label>
        </div>
    </div>

    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="stethoscope" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Perfil profesional</h2>
                <p class="text-xs text-stone-400">Información que se muestra en el sitio público</p>
            </div>
        </div>

        <div class="mt-6">
            <x-form.textarea name="biografia" label="Biografía" :value="$medico?->biografia" rows="10" placeholder="Breve presentación profesional, enfoque y experiencia" />
        </div>
    </div>
</div>
