@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
$maxWidthPx = [
    'sm' => '384',
    'md' => '448',
    'lg' => '512',
    'xl' => '576',
    '2xl' => '672',
][$maxWidth] ?? '576';
@endphp

<div
    x-data="{
        show: @js($show),
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length || 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 z-50"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        class="fixed inset-0 transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-inverse-surface/40 backdrop-blur-sm"></div>
    </div>

    {{-- Scrollable wrapper --}}
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4">
            {{-- Modal Panel --}}
            <div
                x-show="show"
                class="modal-panel relative w-full bg-surface sm:bg-surface/80 sm:backdrop-blur-md overflow-hidden shadow-[0_8px_32px_rgba(0,0,0,0.12)] border-0 sm:border sm:border-white/40 transform transition-all sm:mx-auto rounded-t-[20px] sm:rounded-[24px]"
                style="max-width: {{ $maxWidthPx }}px;"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-0 sm:scale-95"
            >
                {{-- Mobile drag indicator --}}
                <div class="sm:hidden flex justify-center pt-3 pb-1">
                    <div class="w-10 h-1 bg-outline-variant rounded-full"></div>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</div>
