@props(['label', 'value', 'icon' => 'chart', 'tone' => 'sage'])

@php
    $tonos = [
        'sage' => 'bg-sage-50 text-sage-600',
        'cream' => 'bg-cream-100 text-clay-500',
        'stone' => 'bg-stone-100 text-stone-500',
        'rose' => 'bg-rose-50 text-rose-500',
    ][$tone] ?? 'bg-sage-50 text-sage-600';
@endphp

<div class="card p-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm text-stone-500">{{ $label }}</p>
            <p class="mt-2 font-display text-3xl tracking-tight text-sage-900">{{ $value }}</p>
        </div>
        <span class="grid size-11 shrink-0 place-items-center rounded-2xl {{ $tonos }}">
            <x-icon :name="$icon" class="size-5" />
        </span>
    </div>
</div>
