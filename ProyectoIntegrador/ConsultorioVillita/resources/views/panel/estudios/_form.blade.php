@php
    $estudio = $estudio ?? null;
    $pacienteSeleccionado = old('id_paciente', $estudio?->id_paciente ?? $idPaciente ?? request('paciente'));
@endphp

<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="folder" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Datos del estudio</h2>
                <p class="text-xs text-stone-400">Paciente, tipo y descripción</p>
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

            <x-form.select name="id_consulta" label="Consulta relacionada" help="Opcional. Vincula el estudio con una consulta específica.">
                <option value="">Sin consulta relacionada</option>
                @foreach ($consultas as $consulta)
                    <option value="{{ $consulta->id_consulta }}" @selected(old('id_consulta', $estudio?->id_consulta) == $consulta->id_consulta)>
                        {{ $consulta->fecha->translatedFormat('d M Y') }} · {{ $consulta->paciente?->nombre }}
                    </option>
                @endforeach
            </x-form.select>

            <x-form.select name="tipo" label="Tipo de estudio">
                <option value="">Selecciona una opción</option>
                @foreach (['Laboratorio', 'Rayos X', 'Ultrasonido', 'Receta', 'Otro'] as $tipo)
                    <option value="{{ $tipo }}" @selected(old('tipo', $estudio?->tipo) === $tipo)>{{ $tipo }}</option>
                @endforeach
            </x-form.select>

            <x-form.textarea name="descripcion" label="Descripción" :value="$estudio?->descripcion" rows="4" placeholder="Notas o detalles del estudio" />
        </div>
    </div>

    <div class="card p-6 sm:p-8">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="file" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Archivo</h2>
                <p class="text-xs text-stone-400">PDF, imagen o documento</p>
            </div>
        </div>

        @if ($estudio?->nombre_archivo)
            <div class="mt-6 rounded-2xl border border-stone-200/70 bg-cream-50 p-4">
                <p class="text-xs text-stone-400">Archivo actual</p>
                <p class="mt-1 flex items-center gap-2 text-sm font-medium text-stone-700">
                    <x-icon name="file" class="size-4 text-clay-500" />
                    {{ $estudio->nombre_archivo }}
                </p>
                <a href="{{ route('panel.estudios.descargar', $estudio) }}" class="mt-2 inline-flex items-center gap-1.5 text-xs font-medium text-sage-600 hover:text-sage-800">
                    Descargar
                    <x-icon name="download" class="size-3.5" />
                </a>
            </div>
        @endif

        <div class="mt-6">
            <label for="archivo" class="mb-1.5 block text-sm font-medium text-stone-700">
                {{ $estudio ? 'Reemplazar archivo' : 'Archivo' }}
                @unless ($estudio)
                    <span class="text-clay-500">*</span>
                @endunless
            </label>
            <input
                id="archivo"
                name="archivo"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx"
                @unless ($estudio) required @endunless
                class="block w-full cursor-pointer rounded-xl border border-dashed border-stone-300 bg-white px-4 py-6 text-sm text-stone-500 file:mr-4 file:rounded-full file:border-0 file:bg-sage-600 file:px-4 file:py-2 file:text-xs file:font-medium file:text-cream-50 hover:border-sage-400"
            >
            @error('archivo')
                <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-stone-400">Formatos permitidos: PDF, JPG, PNG, WEBP, DOC y DOCX. Tamaño máximo 10 MB.</p>
        </div>

        <div class="mt-6 rounded-2xl bg-cream-50 p-4 text-xs leading-relaxed text-stone-500">
            <p class="flex items-center gap-2 font-medium text-sage-700">
                <x-icon name="shield" class="size-3.5" />
                Privacidad
            </p>
            <p class="mt-1.5">Los archivos se guardan en el almacenamiento privado del consultorio y solo el personal autorizado puede descargarlos.</p>
        </div>
    </div>
</div>
