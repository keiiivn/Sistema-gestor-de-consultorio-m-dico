@props(['estado'])

@php
    $estilos = [
        'pendiente' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'confirmada' => 'bg-sage-50 text-sage-700 ring-sage-200',
        'cancelada' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'atendida' => 'bg-stone-100 text-stone-600 ring-stone-200',
    ][$estado] ?? 'bg-stone-100 text-stone-600 ring-stone-200';
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium capitalize ring-1 ring-inset {{ $estilos }}">
    <span class="size-1.5 rounded-full bg-current"></span>
    {{ $estado }}
</span>
