@extends('layouts.public')

@section('title', 'Consultorio Villita · Medicina cercana para toda la familia')
@section('description', 'Consultorio Villita: medicina general con atención humana, cercana y profesional. Agenda tu cita.')

@section('content')
    <section class="relative overflow-hidden">
        <div class="mx-auto grid max-w-6xl items-center gap-14 px-5 pb-20 pt-16 lg:grid-cols-[1.05fr_0.95fr] lg:pb-28 lg:pt-24">
            <div>
                <p class="eyebrow flex items-center gap-3">
                    <span class="h-px w-8 bg-sage-400"></span>
                    Medicina cercana y humana
                </p>

                <h1 class="mt-5 font-display text-4xl leading-[1.05] tracking-tight text-sage-900 sm:text-5xl lg:text-6xl">
                    Cuidamos de ti y de tu familia,
                    <span class="italic text-sage-600">con calma</span>
                    y cercanía.
                </h1>

                <p class="mt-6 max-w-xl text-base leading-relaxed text-stone-500">
                    En Consultorio Villita creemos que la buena medicina empieza por escuchar. Un espacio tranquilo,
                    con una médica que te conoce por tu nombre y un acompañamiento que va más allá de la consulta.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="tel:+525512345678" class="btn-primary">
                        Agendar una cita
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                    <a href="#servicios" class="btn-soft">Conoce nuestros servicios</a>
                </div>

                <dl class="mt-10 grid max-w-lg grid-cols-3 gap-6 border-t border-stone-200/70 pt-6">
                    <div>
                        <dt class="font-display text-xl text-sage-800 sm:text-2xl">Cercanía</dt>
                        <dd class="mt-1 text-xs leading-snug text-stone-400">Trato humano en cada consulta</dd>
                    </div>
                    <div>
                        <dt class="font-display text-xl text-sage-800 sm:text-2xl">Confianza</dt>
                        <dd class="mt-1 text-xs leading-snug text-stone-400">Atención clara y sin prisas</dd>
                    </div>
                    <div>
                        <dt class="font-display text-xl text-sage-800 sm:text-2xl">Seguimiento</dt>
                        <dd class="mt-1 text-xs leading-snug text-stone-400">Acompañamiento continuo</dd>
                    </div>
                </dl>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 -z-10 rounded-[2.5rem] bg-gradient-to-br from-sage-100 via-cream-100 to-cream-200 opacity-70 blur-2xl"></div>

                <div class="rounded-[2.25rem] border border-stone-200/70 bg-white/70 p-4 shadow-[0_30px_80px_-40px_rgba(43,57,40,0.45)] backdrop-blur">
                    <div class="overflow-hidden rounded-[1.8rem] bg-gradient-to-br from-cream-100 to-sage-100">
                        <x-villa-scene />
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-3 rounded-2xl bg-cream-50 px-4 py-3">
                        <p class="flex items-center gap-2 text-sm text-sage-800">
                            <x-icon name="shield" class="size-4" />
                            Atención profesional
                        </p>
                        <span class="hidden text-xs text-stone-400 sm:block">Atención con cita previa</span>
                    </div>
                </div>

                <div class="absolute -left-6 top-10 hidden rounded-2xl border border-stone-200/70 bg-white px-4 py-3 shadow-lg sm:block">
                    <p class="text-xs text-stone-400">Horario de hoy</p>
                    <p class="mt-0.5 font-display text-lg text-sage-900">9:00 – 19:00</p>
                </div>
            </div>
        </div>
    </section>

    <section id="servicios" class="border-y border-stone-200/60 bg-white/60">
        <div class="mx-auto max-w-6xl px-5 py-20">
            <div class="max-w-2xl">
                <p class="eyebrow">Servicios</p>
                <h2 class="mt-4 font-display text-3xl tracking-tight text-sage-900 sm:text-4xl">
                    Atención integral para cada etapa de la vida
                </h2>
                <p class="mt-4 text-stone-500">
                    Desde la consulta general hasta el seguimiento de tu tratamiento, reunimos los cuidados esenciales en un solo lugar.
                </p>
            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $servicios = [
                        ['icon' => 'stethoscope', 'titulo' => 'Medicina general', 'texto' => 'Valoración, diagnóstico y seguimiento para toda la familia.', 'detalle' => 'Consulta de 30 min'],
                        ['icon' => 'heart', 'titulo' => 'Atención familiar', 'texto' => 'Acompañamiento cercano en cada etapa de la vida.', 'detalle' => 'Todas las edades'],
                        ['icon' => 'clipboard', 'titulo' => 'Control y seguimiento', 'texto' => 'Continuidad para padecimientos y tratamientos.', 'detalle' => 'Seguimiento cercano'],
                        ['icon' => 'pill', 'titulo' => 'Recetas y estudios', 'texto' => 'Recetas claras y resguardo digital de tus estudios médicos.', 'detalle' => 'Expediente seguro'],
                    ];
                @endphp

                @foreach ($servicios as $servicio)
                    <article class="group rounded-3xl border border-stone-200/70 bg-cream-50 p-6 transition duration-300 hover:-translate-y-1 hover:border-sage-300 hover:bg-white hover:shadow-[0_24px_50px_-30px_rgba(43,57,40,0.35)]">
                        <span class="grid size-12 place-items-center rounded-2xl bg-sage-100 text-sage-600 transition group-hover:bg-sage-600 group-hover:text-cream-50">
                            <x-icon :name="$servicio['icon']" class="size-5" />
                        </span>
                        <h3 class="mt-5 font-display text-xl text-sage-900">{{ $servicio['titulo'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-stone-500">{{ $servicio['texto'] }}</p>
                        <p class="mt-5 flex items-center gap-2 text-xs font-medium text-sage-600">
                            <span class="size-1.5 rounded-full bg-sage-400"></span>
                            {{ $servicio['detalle'] }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="nosotros" class="bg-sage-950">
        <div class="mx-auto grid max-w-6xl gap-12 px-5 py-20 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sage-300">Nuestra filosofía</p>
                <h2 class="mt-4 max-w-xl font-display text-3xl leading-tight tracking-tight text-cream-50 sm:text-4xl">
                    La salud se cuida mejor cuando hay confianza.
                </h2>
                <p class="mt-6 max-w-xl text-sm leading-relaxed text-cream-200/70">
                    No se trata solo de tratar síntomas. Queremos conocerte, entender tu historia y acompañarte con
                    decisiones claras. Por eso dedicamos tiempo a cada consulta y explicamos cada paso con sencillez.
                </p>
                <a href="#medicos" class="mt-8 inline-flex items-center gap-2 rounded-full border border-cream-50/20 px-5 py-2.5 text-sm font-medium text-cream-50 transition hover:border-cream-50/40 hover:bg-cream-50/10">
                    Conoce a la doctora
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @php
                    $pilares = [
                        ['icon' => 'clock', 'titulo' => 'Tiempo real', 'texto' => 'Consultas sin prisa, con espacio para todas tus dudas.'],
                        ['icon' => 'heart', 'titulo' => 'Trato humano', 'texto' => 'Te escuchamos y te explicamos con claridad y respeto.'],
                        ['icon' => 'shield', 'titulo' => 'Confidencialidad', 'texto' => 'Tu expediente se resguarda de forma segura y privada.'],
                        ['icon' => 'sparkle', 'titulo' => 'Seguimiento', 'texto' => 'Acompañamos tu tratamiento hasta que te sientas mejor.'],
                    ];
                @endphp

                @foreach ($pilares as $indice => $pilar)
                    <div class="rounded-2xl border border-cream-50/10 bg-cream-50/5 p-5 {{ $indice === 3 ? 'sm:col-span-2' : '' }}">
                        <span class="grid size-10 place-items-center rounded-xl bg-sage-500/20 text-sage-200">
                            <x-icon :name="$pilar['icon']" class="size-5" />
                        </span>
                        <h3 class="mt-4 font-display text-lg text-cream-50">{{ $pilar['titulo'] }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-cream-200/60">{{ $pilar['texto'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="medicos" class="border-b border-stone-200/60">
        <div class="mx-auto max-w-6xl px-5 py-20">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="eyebrow">Atención médica</p>
                    <h2 class="mt-4 font-display text-3xl tracking-tight text-sage-900 sm:text-4xl">
                        Atención cercana, trato humano
                    </h2>
                </div>
                <p class="max-w-sm text-sm text-stone-400">
                    Una atención cercana y profesional, pensada para acompañarte en cada etapa.
                </p>
            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($medicos as $medico)
                    <article class="rounded-3xl border border-stone-200/70 bg-white p-6 transition hover:border-sage-300 hover:shadow-[0_24px_50px_-30px_rgba(43,57,40,0.3)]">
                        <div class="flex items-center gap-4">
                            <span class="grid size-14 shrink-0 place-items-center rounded-full bg-sage-100 font-display text-lg text-sage-700">
                                {{ mb_strtoupper(mb_substr($medico->nombre, 0, 1)) }}{{ mb_strtoupper(mb_substr(strrchr($medico->nombre, ' ') ?: '', 1, 1)) }}
                            </span>
                            <div>
                                <h3 class="font-display text-lg leading-tight text-sage-900">{{ $medico->nombre }}</h3>
                                <p class="mt-0.5 text-xs font-medium uppercase tracking-wider text-sage-500">{{ $medico->especialidad }}</p>
                            </div>
                        </div>
                        <p class="mt-5 text-sm leading-relaxed text-stone-500">{{ $medico->biografia }}</p>
                        <p class="mt-5 flex items-center gap-2 text-xs text-stone-400">
                            <x-icon name="map-pin" class="size-3.5 text-sage-400" />
                            Consultorio {{ $medico->consultorio ?? '—' }}
                        </p>
                    </article>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3">
                        <x-empty-state icon="stethoscope" title="Muy pronto presentaremos a nuestra doctora" description="Estamos preparando su perfil." />
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="contacto" class="bg-cream-100/60">
        <div class="mx-auto max-w-6xl px-5 py-20">
            <div class="overflow-hidden rounded-[2rem] border border-stone-200/70 bg-white shadow-[0_30px_70px_-45px_rgba(43,57,40,0.4)]">
                <div class="grid lg:grid-cols-[1.05fr_0.95fr]">
                    <div class="p-8 sm:p-12">
                        <p class="eyebrow">Contacto</p>
                        <h2 class="mt-4 font-display text-3xl tracking-tight text-sage-900 sm:text-4xl">
                            Tu próxima cita empieza aquí
                        </h2>
                        <p class="mt-4 max-w-md text-sm leading-relaxed text-stone-500">
                            Llámanos o escríbenos por WhatsApp y con gusto buscamos el mejor horario para ti.
                        </p>

                        <ul class="mt-8 space-y-4 text-sm text-stone-600">
                            <li class="flex items-start gap-3">
                                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-sage-50 text-sage-600">
                                    <x-icon name="phone" class="size-4" />
                                </span>
                                <div>
                                    <p class="text-xs text-stone-400">Teléfono y WhatsApp</p>
                                    <a href="tel:+525512345678" class="font-medium text-sage-900 hover:text-sage-700">+52 55 1234 5678</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-sage-50 text-sage-600">
                                    <x-icon name="mail" class="size-4" />
                                </span>
                                <div>
                                    <p class="text-xs text-stone-400">Correo</p>
                                    <a href="mailto:hola@consultoriovillita.mx" class="font-medium text-sage-900 hover:text-sage-700">hola@consultoriovillita.mx</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-sage-50 text-sage-600">
                                    <x-icon name="map-pin" class="size-4" />
                                </span>
                                <div>
                                    <p class="text-xs text-stone-400">Dirección</p>
                                    <p class="font-medium text-sage-900">Calle José Vasconcelos, Mz. 50, Lote 11, Col. Darío Martínez 2.ª Secc.</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="tel:+525512345678" class="btn-primary">
                                Llamar ahora
                                <x-icon name="phone" class="size-4" />
                            </a>
                            <a href="{{ route('login') }}" class="btn-soft">Acceso al personal</a>
                        </div>
                    </div>

                    <div class="border-t border-stone-200/70 bg-gradient-to-br from-sage-900 to-sage-950 p-8 text-cream-100 sm:p-12 lg:border-l lg:border-t-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sage-300">Horarios</p>

                        <dl class="mt-6 space-y-4 text-sm">
                            <div class="flex items-center justify-between border-b border-cream-50/10 pb-4">
                                <dt class="text-cream-200/70">Lunes a viernes</dt>
                                <dd class="font-medium text-cream-50">9:00 – 14:00</dd>
                            </div>
                            <div class="flex items-center justify-between border-b border-cream-50/10 pb-4">
                                <dt class="text-cream-200/70">Lunes a viernes</dt>
                                <dd class="font-medium text-cream-50">16:00 – 19:00</dd>
                            </div>
                            <div class="flex items-center justify-between border-b border-cream-50/10 pb-4">
                                <dt class="text-cream-200/70">Sábado</dt>
                                <dd class="font-medium text-cream-50">9:00 – 14:00</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-cream-200/70">Domingo</dt>
                                <dd class="font-medium text-sage-300">Cerrado</dd>
                            </div>
                        </dl>

                        <div class="mt-8 rounded-2xl border border-cream-50/10 bg-cream-50/5 p-5">
                            <p class="flex items-center gap-2 text-sm font-medium text-cream-50">
                                <x-icon name="alert" class="size-4 text-clay-400" />
                                ¿Es una urgencia?
                            </p>
                            <p class="mt-2 text-xs leading-relaxed text-cream-200/60">
                                Si presentas una emergencia, acude de inmediato al servicio de urgencias más cercano.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
