@php
    $usuario = auth()->user();
    $rol = ['admin' => 'Administración', 'medico' => 'Médico', 'recepcionista' => 'Recepción'][$usuario->rol] ?? $usuario->rol;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel') · Consultorio Villita</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream-50 font-sans text-stone-700">
    <div data-sidebar-overlay data-sidebar-toggle class="fixed inset-0 z-40 hidden bg-sage-950/50 backdrop-blur-sm lg:hidden"></div>

    <aside data-sidebar class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-sage-950 transition-transform duration-300 lg:translate-x-0">
        <div class="flex items-center justify-between px-6 pt-6">
            <a href="{{ route('panel.dashboard') }}" aria-label="Panel Consultorio Villita">
                <x-logo tone="dark" />
            </a>
            <button type="button" data-sidebar-toggle class="grid size-9 place-items-center rounded-full text-cream-200/60 transition hover:bg-cream-50/10 hover:text-cream-50 lg:hidden" aria-label="Cerrar menú">
                <x-icon name="x" class="size-5" />
            </button>
        </div>

        <nav class="mt-8 flex-1 space-y-1 overflow-y-auto px-4 pb-6">
            <x-nav-link route="panel.dashboard" icon="home" :active="request()->routeIs('panel.dashboard')">
                Panel general
            </x-nav-link>
            <x-nav-link route="panel.pacientes.index" icon="users" :active="request()->routeIs('panel.pacientes.*')">
                Pacientes
            </x-nav-link>
            <x-nav-link route="panel.citas.index" icon="calendar" :active="request()->routeIs('panel.citas.*')">
                Citas
            </x-nav-link>

            @if ($usuario->esAdmin() || $usuario->esMedico())
                <x-nav-link route="panel.consultas.index" icon="stethoscope" :active="request()->routeIs('panel.consultas.*')">
                    Consultas
                </x-nav-link>
                <x-nav-link route="panel.recetas.index" icon="pill" :active="request()->routeIs('panel.recetas.*')">
                    Recetas
                </x-nav-link>
            @endif

            <x-nav-link route="panel.estudios.index" icon="folder" :active="request()->routeIs('panel.estudios.*')">
                Estudios
            </x-nav-link>

            @if ($usuario->esAdmin())
                <div class="pt-5">
                    <p class="px-3.5 pb-2 text-[0.65rem] font-semibold uppercase tracking-[0.24em] text-cream-200/40">Administración</p>
                    <x-nav-link route="panel.medicos.index" icon="shield" :active="request()->routeIs('panel.medicos.*')">
                        Médicos
                    </x-nav-link>
                    <x-nav-link route="panel.usuarios.index" icon="lock" :active="request()->routeIs('panel.usuarios.*')">
                        Usuarios
                    </x-nav-link>
                </div>
            @endif
        </nav>

        <div class="border-t border-cream-50/10 p-4">
            <div class="flex items-center gap-3 rounded-2xl bg-cream-50/5 px-3 py-3">
                <span class="grid size-10 shrink-0 place-items-center rounded-full bg-sage-500/30 font-display text-base text-cream-50">
                    {{ mb_strtoupper(mb_substr($usuario->nombre, 0, 1)) }}
                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-cream-50">{{ $usuario->nombre }}</p>
                    <p class="text-xs text-cream-200/50">{{ $rol }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="grid size-8 place-items-center rounded-full text-cream-200/50 transition hover:bg-cream-50/10 hover:text-cream-50" aria-label="Cerrar sesión" title="Cerrar sesión">
                        <x-icon name="logout" class="size-4" />
                    </button>
                </form>
            </div>

            <a href="{{ route('home') }}" class="mt-3 flex items-center justify-center gap-2 rounded-xl px-3 py-2 text-xs font-medium text-cream-200/50 transition hover:bg-cream-50/5 hover:text-cream-50">
                <x-icon name="arrow-right" class="size-3.5" />
                Ver sitio público
            </a>
        </div>
    </aside>

    <div class="lg:pl-72">
        <header class="sticky top-0 z-30 border-b border-stone-200/60 bg-cream-50/85 backdrop-blur">
            <div class="flex items-center gap-4 px-5 py-4 lg:px-10">
                <button type="button" data-sidebar-toggle class="grid size-10 shrink-0 place-items-center rounded-full border border-stone-200 text-stone-600 lg:hidden" aria-label="Abrir menú">
                    <x-icon name="menu" class="size-5" />
                </button>

                <div class="min-w-0 flex-1">
                    <h1 class="truncate font-display text-2xl tracking-tight text-sage-900">@yield('titulo', 'Panel general')</h1>
                    @hasSection('subtitulo')
                        <p class="truncate text-sm text-stone-400">@yield('subtitulo')</p>
                    @endif
                </div>

                <p class="hidden shrink-0 text-right text-xs text-stone-400 sm:block">
                    <span class="block font-medium text-stone-500">{{ now()->translatedFormat('l, d \d\e F') }}</span>
                    <span>{{ now()->format('H:i') }} hrs</span>
                </p>
            </div>
        </header>

        <div class="mx-auto w-full max-w-7xl px-5 py-8 lg:px-10">
            <x-flash />
            @yield('content')
        </div>
    </div>
</body>
</html>
