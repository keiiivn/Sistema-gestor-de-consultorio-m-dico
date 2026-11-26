@props(['compact' => false, 'tone' => 'light'])

@php
    $marca = $tone === 'dark' ? 'bg-cream-100 text-sage-700' : 'bg-sage-600 text-cream-50';
    $titulo = $tone === 'dark' ? 'text-cream-50' : 'text-sage-900';
    $subtitulo = $tone === 'dark' ? 'text-cream-200/70' : 'text-sage-700';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    <span class="grid size-11 shrink-0 place-items-center rounded-2xl shadow-sm {{ $marca }}">
        <svg viewBox="0 0 48 48" fill="none" class="size-7" aria-hidden="true">
            <path d="M8 23.5 24 9l16 14.5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 21v18h24V21" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M19 39V29h10v10" stroke="currentColor" stroke-width="2.4" stroke-linejoin="round"/>
            <path d="M24 32v4.5M21.75 34.25h4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" opacity=".55"/>
        </svg>
    </span>

    @unless ($compact)
        <span class="leading-none">
            <span class="block text-[0.6rem] font-semibold uppercase tracking-[0.32em] {{ $subtitulo }}">Consultorio</span>
            <span class="mt-1 block font-display text-xl {{ $titulo }}">Villita</span>
        </span>
    @endunless
</span>
