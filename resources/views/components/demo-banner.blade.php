@props(['sticky' => false])

@if (demo_mode())
<div class="bg-accent text-on-secondary-fixed h-8 flex items-center justify-center px-4 z-[60] {{ $sticky ? 'sticky top-0' : 'relative' }}">
    <p class="text-xs font-semibold tracking-wide flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l1.9 5.7H20l-4.9 3.6L17 17l-5-3.6L7 17l1.9-5.7L4 7.7h6.1L12 2z"/>
        </svg>
        Mode Demo — data contoh, bukan data asli
    </p>
</div>
@endif
