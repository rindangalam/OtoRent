@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-label-md text-on-surface font-semibold']) }}>
    {{ $value ?? $slot }}
</label>
