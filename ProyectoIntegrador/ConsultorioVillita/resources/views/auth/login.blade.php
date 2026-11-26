@extends('layouts.auth')

@section('title', 'Acceso al panel')

@section('content')
    <div class="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
        <aside class="relative hidden overflow-hidden bg-sage-950 p-12 text-cream-100 lg:flex lg:flex-col lg:justify-between">
            <div class="absolute -right-24 -top-24 size-80 rounded-full bg-sage-500/10 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-16 size-96 rounded-full bg-clay-500/10 blur-3xl"></div>

            <a href="{{ route('home') }}" class="relative">
                <x-logo tone="dark" />
            </a>

            <div class="relative max-w-md">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sage-300">Panel de gestión</p>
                <h1 class="mt-5 font-display text-4xl leading-tight tracking-tight text-cream-50">
                    Todo el cuidado de tus pacientes, en un solo lugar.
                </h1>
                <p class="mt-5 text-sm leading-relaxed text-cream-200/60">
                    Administra pacientes, citas, consultas, recetas y estudios con una experiencia sencilla
                    y ordenada para tu equipo.
                </p>

                <ul class="mt-8 space-y-3 text-sm text-cream-200/70">
                    <li class="flex items-center gap-3">
                        <span class="grid size-8 place-items-center rounded-full bg-sage-500/20 text-sage-200">
                            <x-icon name="calendar" class="size-4" />
                        </span>
                        Agenda clara y sin empalmes
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="grid size-8 place-items-center rounded-full bg-sage-500/20 text-sage-200">
                            <x-icon name="clipboard" class="size-4" />
                        </span>
                        Expedientes completos y seguros
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="grid size-8 place-items-center rounded-full bg-sage-500/20 text-sage-200">
                            <x-icon name="pill" class="size-4" />
                        </span>
                        Recetas listas para imprimir
                    </li>
                </ul>
            </div>

            <p class="relative text-xs text-cream-200/40">© {{ date('Y') }} Consultorio Villita</p>
        </aside>

        <main class="flex items-center justify-center px-5 py-12 sm:px-10">
            <div class="w-full max-w-md">
                <div class="lg:hidden">
                    <a href="{{ route('home') }}">
                        <x-logo />
                    </a>
                </div>

                <p class="eyebrow mt-10 lg:mt-0">Bienvenido de nuevo</p>
                <h2 class="mt-3 font-display text-3xl tracking-tight text-sage-900">Entra al panel</h2>
                <p class="mt-2 text-sm text-stone-500">Usa las credenciales que te proporcionó la administración.</p>

                <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-4">
                    @csrf

                    <x-form.input
                        name="usuario"
                        label="Usuario"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="tu.usuario"
                    />

                    <x-form.input
                        name="password"
                        label="Contraseña"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />

                    <div class="flex items-center justify-between gap-4">
                        <label class="inline-flex items-center gap-2 text-sm text-stone-500">
                            <input type="checkbox" name="remember" value="1" class="size-4 rounded border-stone-300 text-sage-600 focus:ring-sage-400">
                            Recordarme
                        </label>
                        <p class="text-xs text-stone-400">¿Olvidaste tu contraseña? Consulta al administrador.</p>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        Entrar al panel
                        <x-icon name="arrow-right" class="size-4" />
                    </button>
                </form>

                <details class="mt-8 rounded-2xl border border-stone-200/70 bg-white p-4 text-sm">
                    <summary class="cursor-pointer text-sm font-medium text-stone-600">Credenciales de demostración</summary>
                    <div class="mt-3 space-y-2 text-xs text-stone-500">
                        <p class="flex items-center justify-between gap-3"><span class="font-mono text-sage-700">admin / admin123</span><span>Administración</span></p>
                        <p class="flex items-center justify-between gap-3"><span class="font-mono text-sage-700">dra.mendez / medico123</span><span>Médico</span></p>
                        <p class="flex items-center justify-between gap-3"><span class="font-mono text-sage-700">recepcion / recepcion123</span><span>Recepción</span></p>
                    </div>
                </details>

                <p class="mt-6 text-center text-xs text-stone-400">
                    <a href="{{ route('home') }}" class="hover:text-sage-700">Volver al sitio público</a>
                </p>
            </div>
        </main>
    </div>
@endsection
