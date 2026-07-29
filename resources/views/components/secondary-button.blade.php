<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-surface-container text-on-surface-variant rounded-xl border border-outline-variant/30 hover:bg-surface-container-high']) }}>
    {{ $slot }}
</button>
