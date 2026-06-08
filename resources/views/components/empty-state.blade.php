@props([
    'icon' => 'task',
    'title' => 'Belum ada data',
    'description' => 'Saat ini belum ada data yang dapat ditampilkan.',
    'actionText' => null,
    'actionUrl' => '#'
])

<div class="bg-surface rounded-card p-xl flex flex-col items-center justify-center text-center border border-dashed border-outline-variant mt-lg py-12">
    <div class="w-16 h-16 bg-surface-container rounded-full flex items-center justify-center mb-4">
        <span class="material-symbols-outlined text-[32px] text-text-secondary">{{ $icon }}</span>
    </div>
    <h4 class="font-headline-sm text-headline-sm text-text-primary mb-2">{{ $title }}</h4>
    <p class="font-body-md text-body-md text-text-secondary max-w-[384px] mb-6">{{ $description }}</p>
    
    @if($actionText)
        <a href="{{ $actionUrl }}">
            <x-button variant="primary" icon="add">
                {{ $actionText }}
            </x-button>
        </a>
    @endif
</div>
