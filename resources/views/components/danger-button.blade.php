<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-status-danger text-on-error rounded-xl hover:brightness-110']) }}>
    {{ $slot }}
</button>
