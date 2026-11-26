@props(['route', 'icon', 'active' => false])

<a
    href="{{ route($route) }}"
    class="group flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ $active ? 'bg-cream-50/10 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}"
>
    <x-icon :name="$icon" class="size-[1.15rem] shrink-0 {{ $active ? 'text-sage-300' : 'text-cream-200/50 group-hover:text-sage-300' }}" />
    <span>{{ $slot }}</span>
</a>
