<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-secondary-container text-on-secondary-container rounded-xl hover:shadow-lg font-bold btn-interact']) }}>
    {{ $slot }}
</button>
