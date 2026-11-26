@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'rows' => 4,
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

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'input-base resize-y']) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="mt-1.5 text-xs text-clay-600">{{ $message }}</p>
    @enderror

    @if ($help && ! $errors->has($name))
        <p class="mt-1.5 text-xs text-stone-400">{{ $help }}</p>
    @endif
</div>
