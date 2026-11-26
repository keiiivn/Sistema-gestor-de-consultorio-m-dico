@if (session('exito'))
    <div data-flash class="mb-6 flex items-start gap-3 rounded-2xl border border-sage-200 bg-sage-50 px-4 py-3 text-sm text-sage-800">
        <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-sage-600 text-cream-50">
            <x-icon name="check" class="size-3.5" />
        </span>
        <p class="flex-1">{{ session('exito') }}</p>
        <button type="button" data-dismiss class="text-sage-500 transition hover:text-sage-800" aria-label="Cerrar aviso">
            <x-icon name="x" class="size-4" />
        </button>
    </div>
@endif

@if (session('error'))
    <div data-flash class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-rose-500 text-white">
            <x-icon name="alert" class="size-3.5" />
        </span>
        <p class="flex-1">{{ session('error') }}</p>
        <button type="button" data-dismiss class="text-rose-400 transition hover:text-rose-700" aria-label="Cerrar aviso">
            <x-icon name="x" class="size-4" />
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-clay-400/40 bg-clay-400/10 px-4 py-3 text-sm text-clay-600">
        <p class="font-medium">Revisa la información capturada:</p>
        <ul class="mt-1 list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
