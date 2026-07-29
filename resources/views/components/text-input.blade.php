@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl w-full']) }}>
