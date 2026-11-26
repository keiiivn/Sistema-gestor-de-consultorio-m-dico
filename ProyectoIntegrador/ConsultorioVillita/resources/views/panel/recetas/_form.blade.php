@php
    $receta = $receta ?? null;
    $consultaSeleccionada = old('id_consulta', $receta?->id_consulta ?? $idConsulta ?? request('consulta'));

    $filas = old('medicamentos');

    if ($filas === null) {
        $filas = $receta?->medicamentos
            ?->map(fn ($medicamento) => $medicamento->only([
                'medicamento',
                'presentacion',
                'dosis',
                'frecuencia',
                'duracion',
                'via_administracion',
                'indicaciones',
            ]))
            ->all() ?? [];
    }

    if (empty($filas)) {
        $filas = [[
            'medicamento' => '',
            'presentacion' => '',
            'dosis' => '',
            'frecuencia' => '',
            'duracion' => '',
            'via_administracion' => '',
            'indicaciones' => '',
        ]];
    }
@endphp

<div class="card p-6 sm:p-8">
    <div class="flex items-center gap-3">
        <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
            <x-icon name="clipboard" class="size-5" />
        </span>
        <div>
            <h2 class="font-display text-xl text-sage-900">Consulta y paciente</h2>
            <p class="text-xs text-stone-400">Datos que aparecerán en la receta</p>
        </div>
    </div>

    <div class="mt-6 grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <x-form.select name="id_consulta" label="Consulta" required>
                <option value="">Selecciona la consulta</option>
                @foreach ($consultas as $consulta)
                    <option
                        value="{{ $consulta->id_consulta }}"
                        data-nombre="{{ $consulta->paciente?->nombre }}"
                        data-edad="{{ $consulta->paciente?->edad }}"
                        @selected($consultaSeleccionada == $consulta->id_consulta)
                    >
                        {{ $consulta->fecha->translatedFormat('d M Y') }} · {{ $consulta->paciente?->nombre }} · {{ $consulta->diagnostico ?: 'Consulta' }}
                    </option>
                @endforeach
            </x-form.select>
        </div>

        <x-form.input name="nombre_paciente" label="Nombre del paciente" :value="$receta?->nombre_paciente" placeholder="Se completa desde la consulta" />
        <x-form.input name="edad" label="Edad" type="number" min="0" max="120" :value="$receta?->edad" placeholder="Años" />

        <x-form.input name="altura" label="Altura (m)" type="number" step="0.01" min="0" max="3" :value="$receta?->altura" placeholder="1.70" />
        <x-form.input name="peso" label="Peso (kg)" type="number" step="0.01" min="0" max="500" :value="$receta?->peso" placeholder="68.00" />

        <div class="sm:col-span-2">
            <x-form.textarea name="indicaciones" label="Indicaciones generales" :value="$receta?->indicaciones" rows="3" placeholder="Recomendaciones generales para el paciente" />
        </div>
    </div>
</div>

<div class="card mt-6 p-6 sm:p-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-xl bg-sage-50 text-sage-600">
                <x-icon name="pill" class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-xl text-sage-900">Medicamentos</h2>
                <p class="text-xs text-stone-400">Agrega cada medicamento con su dosis e indicaciones</p>
            </div>
        </div>

        <button type="button" data-add-medicamento class="btn-soft px-4 py-2.5">
            <x-icon name="plus" class="size-4" />
            Agregar medicamento
        </button>
    </div>

    <div data-medicamentos class="mt-5 space-y-4">
        @foreach ($filas as $indice => $fila)
            <div data-medicamento-row class="rounded-2xl border border-stone-200/70 bg-cream-50/60 p-4">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-sage-600">Medicamento {{ $indice + 1 }}</p>
                    <button type="button" data-remove-medicamento class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-rose-50 hover:text-rose-600" title="Quitar medicamento">
                        <x-icon name="trash" class="size-4" />
                    </button>
                </div>

                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    <input name="medicamentos[{{ $indice }}][medicamento]" value="{{ $fila['medicamento'] ?? '' }}" placeholder="Nombre del medicamento" class="input-base sm:col-span-2">
                    <input name="medicamentos[{{ $indice }}][presentacion]" value="{{ $fila['presentacion'] ?? '' }}" placeholder="Presentación (tabletas 500 mg)" class="input-base">
                    <input name="medicamentos[{{ $indice }}][dosis]" value="{{ $fila['dosis'] ?? '' }}" placeholder="Dosis (1 tableta)" class="input-base">
                    <input name="medicamentos[{{ $indice }}][frecuencia]" value="{{ $fila['frecuencia'] ?? '' }}" placeholder="Frecuencia (cada 8 horas)" class="input-base">
                    <input name="medicamentos[{{ $indice }}][duracion]" value="{{ $fila['duracion'] ?? '' }}" placeholder="Duración (5 días)" class="input-base">
                    <input name="medicamentos[{{ $indice }}][via_administracion]" value="{{ $fila['via_administracion'] ?? '' }}" placeholder="Vía de administración (oral)" class="input-base">
                    <textarea name="medicamentos[{{ $indice }}][indicaciones]" rows="2" placeholder="Indicaciones específicas" class="input-base resize-y">{{ $fila['indicaciones'] ?? '' }}</textarea>
                </div>
            </div>
        @endforeach
    </div>

    <template id="medicamento-template">
        <div data-medicamento-row class="rounded-2xl border border-stone-200/70 bg-cream-50/60 p-4">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-sage-600">Nuevo medicamento</p>
                <button type="button" data-remove-medicamento class="grid size-8 place-items-center rounded-lg text-stone-400 transition hover:bg-rose-50 hover:text-rose-600" title="Quitar medicamento">
                    <x-icon name="trash" class="size-4" />
                </button>
            </div>

            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                <input name="medicamentos[__INDEX__][medicamento]" placeholder="Nombre del medicamento" class="input-base sm:col-span-2">
                <input name="medicamentos[__INDEX__][presentacion]" placeholder="Presentación (tabletas 500 mg)" class="input-base">
                <input name="medicamentos[__INDEX__][dosis]" placeholder="Dosis (1 tableta)" class="input-base">
                <input name="medicamentos[__INDEX__][frecuencia]" placeholder="Frecuencia (cada 8 horas)" class="input-base">
                <input name="medicamentos[__INDEX__][duracion]" placeholder="Duración (5 días)" class="input-base">
                <input name="medicamentos[__INDEX__][via_administracion]" placeholder="Vía de administración (oral)" class="input-base">
                <textarea name="medicamentos[__INDEX__][indicaciones]" rows="2" placeholder="Indicaciones específicas" class="input-base resize-y"></textarea>
            </div>
        </div>
    </template>
</div>
