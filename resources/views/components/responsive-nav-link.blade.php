@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-primary text-start text-base font-medium text-on-surface bg-surface-container focus:outline-none focus:border-primary focus:bg-surface-container-high transition-colors'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-on-surface-variant hover:text-primary hover:bg-surface-container hover:border-outline-variant focus:outline-none focus:text-on-surface focus:bg-surface-container focus:border-outline-variant transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
