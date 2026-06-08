@props([
    'type' => 'warning', // warning, success, danger
    'message' => 'Pesan alert di sini'
])

@php
    $classes = match($type) {
        'warning' => 'bg-warning/10 text-warning border-warning/30',
        'success' => 'bg-success/10 text-success border-success/30',
        'danger' => 'bg-danger/10 text-danger border-danger/30',
        default => 'bg-warning/10 text-warning border-warning/30',
    };
    
    $icon = match($type) {
        'warning' => 'warning',
        'success' => 'check_circle',
        'danger' => 'error',
        default => 'warning',
    };
@endphp

<div class="{{ $classes }} border px-4 py-3 rounded-lg flex items-center gap-3 font-body-md text-body-md mb-lg">
    <span class="material-symbols-outlined text-[20px]">{{ $icon }}</span>
    <span>{{ $message }}</span>
</div>
