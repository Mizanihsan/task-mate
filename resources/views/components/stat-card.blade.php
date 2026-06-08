@props([
    'color' => 'primary',
    'icon' => 'assignment',
    'label' => 'Stat Label',
    'value' => '0'
])

@php
    $bgColorClass = match($color) {
        'primary' => 'bg-primary',
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-danger',
        default => 'bg-primary',
    };
    
    $textColorClass = match($color) {
        'primary' => 'text-primary',
        'success' => 'text-success',
        'warning' => 'text-warning',
        'danger' => 'text-danger',
        default => 'text-primary',
    };

    $iconBgClass = match($color) {
        'primary' => 'bg-primary-fixed',
        'success' => 'bg-success/10',
        'warning' => 'bg-warning/10',
        'danger' => 'bg-danger/10',
        default => 'bg-primary/10',
    };
@endphp

<div class="bg-surface rounded-card p-6 shadow-level-1 relative overflow-hidden flex flex-col justify-between">
    <div class="absolute left-0 top-0 bottom-0 w-1 {{ $bgColorClass }}"></div>
    <div class="flex justify-between items-start mb-4">
        <span class="material-symbols-outlined {{ $textColorClass }} {{ $iconBgClass }} p-2 rounded-full">{{ $icon }}</span>
    </div>
    <div>
        <p class="font-label-md text-label-md text-text-secondary uppercase mb-1">{{ $label }}</p>
        <h3 class="font-headline-lg text-headline-lg text-text-primary">{{ $value }}</h3>
    </div>
</div>
