<!-- Mobile Bottom Navigation — Fixed like a native app -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
    <div class="bg-surface/95 backdrop-blur-lg border-t border-border/60 shadow-[0_-2px_20px_rgba(0,0,0,0.08)]">
        <div class="flex justify-around items-end h-16 px-2 relative">
            {{-- Dashboard --}}
            <a href="/dashboard" class="flex flex-col items-center justify-center gap-0.5 pt-2 pb-1 w-16 group relative">
                @if(request()->is('dashboard'))
                    <span class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-[3px] bg-primary rounded-full"></span>
                @endif
                <span class="material-symbols-outlined text-[22px] {{ request()->is('dashboard') ? 'text-primary icon-fill' : 'text-text-secondary group-hover:text-primary' }} transition-colors">dashboard</span>
                <span class="text-[10px] font-semibold leading-none {{ request()->is('dashboard') ? 'text-primary' : 'text-text-secondary group-hover:text-primary' }} transition-colors">Dashboard</span>
            </a>

            {{-- Tugas --}}
            <a href="/tasks" class="flex flex-col items-center justify-center gap-0.5 pt-2 pb-1 w-16 group relative">
                @if(request()->is('tasks'))
                    <span class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-[3px] bg-primary rounded-full"></span>
                @endif
                <span class="material-symbols-outlined text-[22px] {{ request()->is('tasks') ? 'text-primary icon-fill' : 'text-text-secondary group-hover:text-primary' }} transition-colors">assignment</span>
                <span class="text-[10px] font-semibold leading-none {{ request()->is('tasks') ? 'text-primary' : 'text-text-secondary group-hover:text-primary' }} transition-colors">Tugas</span>
            </a>

            {{-- Tambah (FAB-style Center Button) --}}
            <a href="/tasks/create" class="flex flex-col items-center justify-center -mt-5 group relative">
                <div class="w-12 h-12 rounded-full bg-primary shadow-[0_4px_14px_rgba(35,58,135,0.4)] flex items-center justify-center group-hover:scale-110 group-active:scale-95 transition-transform">
                    <span class="material-symbols-outlined text-[26px] text-on-primary">add</span>
                </div>
                <span class="text-[10px] font-semibold leading-none text-primary mt-1">Tambah</span>
            </a>

            {{-- Riwayat --}}
            <a href="/tasks/history" class="flex flex-col items-center justify-center gap-0.5 pt-2 pb-1 w-16 group relative">
                @if(request()->is('tasks/history'))
                    <span class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-[3px] bg-primary rounded-full"></span>
                @endif
                <span class="material-symbols-outlined text-[22px] {{ request()->is('tasks/history') ? 'text-primary icon-fill' : 'text-text-secondary group-hover:text-primary' }} transition-colors">history</span>
                <span class="text-[10px] font-semibold leading-none {{ request()->is('tasks/history') ? 'text-primary' : 'text-text-secondary group-hover:text-primary' }} transition-colors">Riwayat</span>
            </a>

            {{-- Profil / Logout --}}
            <div class="flex flex-col items-center justify-center gap-0.5 pt-2 pb-1 w-16 group relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex flex-col items-center gap-0.5 bg-transparent border-0 cursor-pointer">
                    <div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[11px] font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="text-[10px] font-semibold leading-none text-text-secondary group-hover:text-primary transition-colors">Profil</span>
                </button>

                {{-- Popup --}}
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" style="display: none;" class="absolute bottom-full right-0 mb-2 w-48 bg-surface rounded-xl shadow-level-2 border border-border overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-border">
                        <p class="text-sm text-text-primary font-semibold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-text-secondary truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-danger hover:bg-surface-variant transition-colors flex items-center gap-2 cursor-pointer bg-transparent border-0">
                            <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
