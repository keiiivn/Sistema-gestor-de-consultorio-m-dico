@php($usuario = $usuario ?? null)

<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="user" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Datos de la cuenta</h2>
                <p class="text-xs text-stone-400">Información de identificación y acceso</p>
            </div>
        </div>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-form.input name="nombre" label="Nombre completo" :value="$usuario?->nombre" required placeholder="Nombre y apellidos" />
            </div>

            <x-form.input name="usuario" label="Usuario" :value="$usuario?->usuario" required placeholder="nombre.usuario" help="Solo letras, números, guiones y guiones bajos." />
            <x-form.input name="email" label="Correo electrónico" type="email" :value="$usuario?->email" required placeholder="usuario@consultoriovillita.mx" />

            <x-form.input
                name="password"
                label="Contraseña"
                type="password"
                :required="! $usuario"
                autocomplete="new-password"
                :placeholder="$usuario ? 'Dejar vacío para conservar la actual' : 'Mínimo 8 caracteres'"
                :help="$usuario ? 'Solo escribe una contraseña si deseas cambiarla.' : null"
            />

            <x-form.input name="telefono" label="Teléfono" :value="$usuario?->telefono" placeholder="55 1234 5678" />
        </div>
    </div>

    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="shield" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Rol y estado</h2>
                <p class="text-xs text-stone-400">Permisos dentro del sistema</p>
            </div>
        </div>

        <div class="mt-6 space-y-5">
            <x-form.select name="rol" label="Rol" required>
                @foreach ($roles as $rol)
                    <option value="{{ $rol }}" @selected(old('rol', $usuario?->rol ?? 'recepcionista') === $rol)>
                        {{ ucfirst($rol) }}
                    </option>
                @endforeach
            </x-form.select>

            <label class="inline-flex items-center gap-2.5 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm text-stone-600">
                <input type="checkbox" name="activo" value="1" @checked(old('activo', $usuario?->activo ?? true)) class="size-4 rounded border-stone-300 text-sage-600 focus:ring-sage-400">
                Cuenta activa
            </label>

            <div class="rounded-2xl bg-cream-50 p-4 text-xs leading-relaxed text-stone-500">
                <p class="font-medium text-sage-700">Roles del sistema</p>
                <ul class="mt-2 space-y-1.5">
                    <li><span class="font-medium text-stone-600">Administración:</span> acceso total, incluyendo usuarios y médicos.</li>
                    <li><span class="font-medium text-stone-600">Médico:</span> pacientes, citas, consultas, recetas y estudios.</li>
                    <li><span class="font-medium text-stone-600">Recepción:</span> pacientes, citas y estudios.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
