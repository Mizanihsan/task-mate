@props([
    'status' => 'pending', // pending, completed, overdue
    'label' => null
])

@php
    if (!$label) {
        $label = match($status) {
            'completed' => 'Selesai',
            'pending' => 'Belum Selesai',
            'overdue' => 'Terlambat',
            default => 'Unknown'
        };
    }

    $classes = match($status) {
        'completed' => 'bg-success/10 text-success',
        'pending' => 'bg-warning/10 text-warning',
        'overdue' => 'bg-danger/10 text-danger',
        default => 'bg-surface-container text-text-secondary'
    };
    
    $icon = match($status) {
        'completed' => 'check_circle',
        'pending' => 'schedule',
        'overdue' => 'warning',
        default => 'info'
    };
@endphp

<span class="{{ $classes }} font-label-md text-label-md px-2.5 py-1 rounded-full inline-flex items-center gap-1">
    <span class="material-symbols-outlined text-[14px] {{ $status == 'completed' ? 'fill' : '' }}">{{ $icon }}</span> 
    {{ $label }}
</span>
