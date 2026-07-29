@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-status-success bg-status-success/10 border border-status-success/20 rounded-lg p-3']) }}>
        {{ $status }}
    </div>
@endif
