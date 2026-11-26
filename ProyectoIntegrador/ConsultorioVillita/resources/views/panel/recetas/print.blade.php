<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receta #{{ str_pad((string) $receta->id_receta, 4, '0', STR_PAD_LEFT) }} · Consultorio Villita</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .paper { box-shadow: none; border: none; }
        }
    </style>
</head>
<body class="min-h-screen bg-stone-100 py-8 print:bg-white print:py-0">
    <div class="no-print mx-auto mb-5 flex max-w-3xl items-center justify-between px-4">
        <a href="{{ route('panel.recetas.show', $receta) }}" class="text-sm text-stone-500 hover:text-stone-800">Volver a la receta</a>
        <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-full bg-sage-600 px-5 py-2.5 text-sm font-medium text-cream-50 transition hover:bg-sage-700">
            <x-icon name="print" class="size-4" />
            Imprimir receta
        </button>
    </div>

    <main class="paper mx-auto max-w-3xl rounded-2xl border border-stone-200 bg-white px-8 py-10 shadow-sm sm:px-12 sm:py-14">
        <header class="flex flex-col gap-6 border-b border-stone-200 pb-6 sm:flex-row sm:items-start sm:justify-between">
            <x-logo />

            <div class="text-left text-xs leading-relaxed text-stone-500 sm:text-right">
                <p class="font-medium text-stone-700">Consultorio Villita</p>
                <p>Calle José Vasconcelos, Mz. 50, Lote 11, Col. Darío Martínez 2.ª Secc.</p>
                <p>+52 55 1234 5678 · hola@consultoriovillita.mx</p>
            </div>
        </header>

        <div class="mt-6 flex items-center justify-between">
            <div>
                <p class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-sage-600">Receta médica</p>
                <p class="mt-1 font-display text-2xl text-sage-900">Folio #{{ str_pad((string) $receta->id_receta, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <p class="text-xs text-stone-400">{{ $receta->fecha_registro?->translatedFormat('d \d\e F \d\e Y') }}</p>
        </div>

        <section class="mt-6 grid gap-3 rounded-xl bg-cream-50 p-5 text-sm sm:grid-cols-2">
            <p><span class="text-stone-400">Paciente:</span> <span class="font-medium text-stone-800">{{ $receta->nombre_paciente ?: $receta->consulta?->paciente?->nombre }}</span></p>
            <p><span class="text-stone-400">Edad:</span> {{ $receta->edad ? $receta->edad.' años' : '—' }}</p>
            <p><span class="text-stone-400">Altura:</span> {{ $receta->altura ? $receta->altura.' m' : '—' }}</p>
            <p><span class="text-stone-400">Peso:</span> {{ $receta->peso ? $receta->peso.' kg' : '—' }}</p>
            @if ($receta->consulta?->diagnostico)
                <p class="sm:col-span-2"><span class="text-stone-400">Diagnóstico:</span> {{ $receta->consulta->diagnostico }}</p>
            @endif
        </section>

        <section class="mt-8">
            <h2 class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-sage-600">Medicamentos</h2>

            <table class="mt-3 w-full border-collapse text-sm">
                <thead>
                    <tr class="border-b border-stone-200 text-left text-xs uppercase tracking-wider text-stone-400">
                        <th class="py-2 pr-3">Medicamento</th>
                        <th class="py-2 pr-3">Dosis</th>
                        <th class="py-2 pr-3">Frecuencia</th>
                        <th class="py-2 pr-3">Duración</th>
                        <th class="py-2">Vía</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receta->medicamentos as $medicamento)
                        <tr class="border-b border-stone-100 align-top">
                            <td class="py-3 pr-3">
                                <span class="block font-medium text-stone-800">{{ $medicamento->medicamento }}</span>
                                @if ($medicamento->presentacion)
                                    <span class="block text-xs text-stone-400">{{ $medicamento->presentacion }}</span>
                                @endif
                                @if ($medicamento->indicaciones)
                                    <span class="block text-xs text-stone-400">{{ $medicamento->indicaciones }}</span>
                                @endif
                            </td>
                            <td class="py-3 pr-3 text-stone-600">{{ $medicamento->dosis ?: '—' }}</td>
                            <td class="py-3 pr-3 text-stone-600">{{ $medicamento->frecuencia ?: '—' }}</td>
                            <td class="py-3 pr-3 text-stone-600">{{ $medicamento->duracion ?: '—' }}</td>
                            <td class="py-3 text-stone-600">{{ $medicamento->via_administracion ?: '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        @if ($receta->indicaciones)
            <section class="mt-8">
                <h2 class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-sage-600">Indicaciones generales</h2>
                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-stone-600">{{ $receta->indicaciones }}</p>
            </section>
        @endif

        <footer class="mt-14 flex flex-col gap-8 sm:flex-row sm:items-end sm:justify-between">
            <p class="max-w-xs text-[0.65rem] leading-relaxed text-stone-400">
                Esta receta es válida únicamente para el paciente indicado. No se automedique y siga las indicaciones del profesional de la salud.
            </p>

            <div class="text-center">
                <div class="mx-auto h-10 w-52 border-b border-stone-300"></div>
                <p class="mt-2 text-sm font-medium text-stone-700">{{ $receta->consulta?->medico?->nombre ?? 'Médico tratante' }}</p>
                <p class="text-xs text-stone-400">{{ $receta->consulta?->medico?->especialidad }}</p>
                @if ($receta->consulta?->medico?->cedula)
                    <p class="text-xs text-stone-400">Cédula {{ $receta->consulta->medico->cedula }}</p>
                @endif
            </div>
        </footer>
    </main>
</body>
</html>
