@props([
    'name',
    'label' => null,
    'required' => false,
    'help' => null,
])

@php($id = $attributes->get('id') ?? 'campo-'.$name)

<div>
    @if ($label)
        <label for="{{ $id }}" class="mb-1.5 block text-sm font-medium text-stone-700">
            {{ $label }}
            @if ($required)
                <span class="text-clay-500">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'input-base cursor-pointer appearance-none bg-[length:1rem] bg-[right_0.9rem_center] bg-no-repeat pr-10']) }}
        style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2378716c' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E&quot;);"
    >
        {{ $slot }}
    </select>

    @error($name)
        <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
    @enderror

    @if ($help && ! $errors->has($name))
        <p class="mt-1.5 text-xs text-stone-400">{{ $help }}</p>
    @endif
</div>
