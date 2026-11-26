@props(['icon' => 'leaf', 'title', 'description' => null])

<div class="flex flex-col items-center justify-center px-6 py-16 text-center">
    <span class="grid size-14 place-items-center rounded-2xl bg-sage-50 text-sage-500">
        <x-icon :name="$icon" class="size-6" />
    </span>
    <h3 class="mt-4 font-display text-xl text-sage-900">{{ $title }}</h3>

    @if ($description)
        <p class="mt-1.5 max-w-sm text-sm text-stone-500">{{ $description }}</p>
    @endif

    @if (isset($accion))
        <div class="mt-5">{{ $accion }}</div>
    @endif
</div>
