@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, ghost, danger
    'icon' => null,
    'fullWidth' => false,
])

@php
    $baseClasses = 'font-label-md text-label-md rounded-lg shadow-sm transition-all flex items-center justify-center gap-xs px-md py-[10px] h-fit';
    
    $variantClasses = match($variant) {
        'primary' => 'bg-primary-container hover:bg-primary text-white hover:shadow-level-1',
        'secondary' => 'bg-secondary text-white hover:bg-secondary/90',
        'ghost' => 'bg-transparent border border-outline-variant text-text-secondary hover:bg-surface-container-low hover:text-text-primary',
        'danger' => 'bg-transparent border border-danger text-danger hover:bg-danger/10',
        default => 'bg-primary-container hover:bg-primary text-white hover:shadow-level-1',
    };
    
    $widthClass = $fullWidth ? 'w-full' : '';
    
    $classes = "$baseClasses $variantClasses $widthClass";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
    @endif
    {{ $slot }}
</button>
