<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Consultorio Villita · Medicina cercana')</title>
    <meta name="description" content="@yield('description', 'Consultorio Villita: atención médica cercana, humana y profesional para toda la familia.')">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream-50 font-sans text-stone-700">
    <header class="sticky top-0 z-40 border-b border-stone-200/60 bg-cream-50/85 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4">
            <a href="{{ route('home') }}" aria-label="Consultorio Villita, inicio">
                <x-logo />
            </a>

            <nav class="hidden items-center gap-8 text-sm font-medium text-stone-600 md:flex">
                <a href="{{ route('home') }}#servicios" class="transition hover:text-sage-700">Servicios</a>
                <a href="{{ route('home') }}#nosotros" class="transition hover:text-sage-700">Nosotros</a>
                <a href="{{ route('home') }}#medicos" class="transition hover:text-sage-700">Médica</a>
                <a href="{{ route('home') }}#contacto" class="transition hover:text-sage-700">Contacto</a>
                <a href="{{ route('login') }}" class="text-stone-400 transition hover:text-sage-700">Acceso personal</a>
                <a href="{{ route('home') }}#contacto" class="btn-primary px-5 py-2.5">Agendar cita</a>
            </nav>

            <button type="button" data-nav-toggle class="grid size-10 place-items-center rounded-full border border-stone-200 text-stone-600 md:hidden" aria-label="Abrir menú">
                <x-icon name="menu" class="size-5" />
            </button>
        </div>

        <div data-nav-menu class="hidden border-t border-stone-200/60 bg-cream-50 md:hidden">
            <nav class="mx-auto flex max-w-6xl flex-col gap-1 px-5 py-4 text-sm font-medium text-stone-600">
                <a href="{{ route('home') }}#servicios" class="rounded-xl px-3 py-2.5 hover:bg-sage-50">Servicios</a>
                <a href="{{ route('home') }}#nosotros" class="rounded-xl px-3 py-2.5 hover:bg-sage-50">Nosotros</a>
                <a href="{{ route('home') }}#medicos" class="rounded-xl px-3 py-2.5 hover:bg-sage-50">Médica</a>
                <a href="{{ route('home') }}#contacto" class="rounded-xl px-3 py-2.5 hover:bg-sage-50">Contacto</a>
                <a href="{{ route('login') }}" class="rounded-xl px-3 py-2.5 hover:bg-sage-50">Acceso personal</a>
                <a href="{{ route('home') }}#contacto" class="mt-2 rounded-full bg-sage-600 px-5 py-2.5 text-center text-cream-50">Agendar cita</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-stone-200/60 bg-cream-100/60">
        <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-[1.4fr_1fr_1fr]">
            <div>
                <x-logo />
                <p class="mt-5 max-w-xs text-sm leading-relaxed text-stone-500">
                    Un espacio tranquilo para cuidar tu salud y la de tu familia, con atención cercana y profesional.
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-700">Visítanos</p>
                <ul class="mt-4 space-y-3 text-sm text-stone-500">
                    <li class="flex items-start gap-2.5">
                        <x-icon name="map-pin" class="mt-0.5 size-4 text-sage-500" />
                        Calle José Vasconcelos, Mz. 50, Lote 11, Col. Darío Martínez 2.ª Secc.
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-icon name="clock" class="mt-0.5 size-4 text-sage-500" />
                        Lun a Vie · 9:00 – 19:00
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-icon name="phone" class="mt-0.5 size-4 text-sage-500" />
                        <a href="tel:+525512345678" class="hover:text-sage-700">+52 55 1234 5678</a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sage-700">Enlaces</p>
                <ul class="mt-4 space-y-3 text-sm text-stone-500">
                    <li><a href="{{ route('home') }}#servicios" class="hover:text-sage-700">Servicios</a></li>
                    <li><a href="{{ route('home') }}#medicos" class="hover:text-sage-700">Nuestra médica</a></li>
                    <li><a href="{{ route('home') }}#contacto" class="hover:text-sage-700">Contacto</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-sage-700">Acceso al personal</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-stone-200/60">
            <div class="mx-auto flex max-w-6xl flex-col gap-2 px-5 py-5 text-xs text-stone-400 sm:flex-row sm:items-center sm:justify-between">
                <p>© {{ date('Y') }} Consultorio Villita. Todos los derechos reservados.</p>
                <p>Aviso de privacidad · Política de cookies</p>
            </div>
        </div>
    </footer>
</body>
</html>
