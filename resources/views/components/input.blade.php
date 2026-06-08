@props([
    'type' => 'text',
    'name',
    'label' => null,
    'placeholder' => '',
    'icon' => null,
    'required' => false,
])

<div class="w-full">
    @if($label)
        <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="{{ $name }}">
            {{ $label }} @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-sm text-text-secondary">
                <span class="material-symbols-outlined">{{ $icon }}</span>
            </span>
        @endif
        
        <input 
            type="{{ $type }}" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            placeholder="{{ $placeholder }}" 
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full ' . ($icon ? 'pl-[44px]' : 'pl-sm') . ' pr-sm py-sm bg-surface border border-outline-variant rounded-[10px] focus:ring-2 focus:ring-secondary focus:border-secondary font-body-md text-body-md text-text-primary transition-shadow']) }}
        />
    </div>
</div>
