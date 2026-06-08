@extends('layouts.app')

@section('title', 'Riwayat Tugas')

@section('content')
<div class="max-w-[1024px] mx-auto w-full">
<!-- TopAppBar (matches Dashboard) -->
<header class="bg-surface md:bg-transparent text-primary md:text-text-primary fixed md:static top-0 right-0 left-0 h-14 md:h-auto shadow-sm md:shadow-none flex items-center justify-between px-4 md:px-0 w-full z-30 mb-lg">
    <div class="flex items-center gap-sm">
        <!-- Mobile Brand Title -->
        <h2 class="font-headline-md text-headline-md font-bold text-primary md:hidden">TaskMate</h2>
        
        <!-- Desktop Header Title -->
        <div class="hidden md:block">
            <h1 class="font-headline-lg text-headline-lg text-text-primary mb-1">Riwayat Tugas</h1>
            <p class="font-body-md text-body-md text-text-secondary">Daftar tugas yang telah Anda selesaikan.</p>
        </div>
    </div>
    <div class="flex items-center gap-xs">
        <button class="p-2 text-text-secondary hover:bg-surface-container hover:text-primary transition-all rounded-full relative md:hidden">
            <span class="material-symbols-outlined">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-danger rounded-full border border-surface"></span>
        </button>
        
        <!-- Profile & Logout Dropdown -->
        <div class="relative ml-2" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 p-1 border border-border rounded-full hover:bg-surface-variant transition-colors cursor-pointer">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </button>
            <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-surface rounded-card shadow-level-2 border border-border overflow-hidden z-50">
                <div class="px-4 py-3 border-b border-border">
                    <p class="text-sm text-text-primary font-medium truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-text-secondary truncate">{{ Auth::user()->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-danger hover:bg-surface-variant transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="mt-16 md:mt-0">
    <!-- Mobile Welcome Message (matches Dashboard pattern) -->
    <div class="md:hidden mb-md">
        <h2 class="font-headline-md text-headline-md text-text-primary mb-1">Riwayat Tugas</h2>
        <p class="font-body-md text-body-md text-text-secondary">Daftar tugas yang telah Anda selesaikan.</p>
    </div>

    <!-- Filters -->
    <div class="mb-lg flex flex-col sm:flex-row sm:items-end justify-end gap-4">
        <form action="{{ route('tasks.history') }}" method="GET" class="flex flex-wrap gap-2">
            <div class="relative">
                <select name="course" onchange="this.form.submit()" class="bg-surface border border-border rounded-lg pl-4 pr-10 py-2 font-body-md text-body-md text-text-secondary focus:outline-none focus:ring-2 focus:ring-secondary cursor-pointer shadow-sm appearance-none">
                    <option value="">Semua Mata Kuliah</option>
                    @foreach($courses as $c)
                        <option value="{{ $c }}" {{ request('course') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none text-[20px]">expand_more</span>
            </div>
            <div class="relative">
                <select name="period" onchange="this.form.submit()" class="bg-surface border border-border rounded-lg pl-4 pr-10 py-2 font-body-md text-body-md text-text-secondary focus:outline-none focus:ring-2 focus:ring-secondary cursor-pointer shadow-sm appearance-none">
                    <option value="">Semua Waktu</option>
                    <option value="bulan_ini" {{ request('period') === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="bulan_lalu" {{ request('period') === 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none text-[20px]">expand_more</span>
            </div>
        </form>
    </div>

    <!-- Timeline Layout for Completed Tasks -->
    <div class="relative border-l-2 border-border ml-4 md:ml-6 space-y-8 pb-12 mt-8">
        
        @forelse($tasks as $month => $tasksGroup)
        <!-- Task Group -->
        <div class="relative">
            <span class="absolute left-[-1px] -translate-x-1/2 -top-3 bg-surface-container-low text-text-secondary px-3 py-1 rounded-full font-label-md text-label-md border border-border whitespace-nowrap shadow-sm z-20">{{ $month }}</span>
            
            <div class="pt-8 space-y-6">
                @foreach($tasksGroup as $task)
                <!-- Task Item -->
                <div class="relative pl-8 md:pl-12 group">
                    <div class="absolute -left-[9px] top-4 w-4 h-4 rounded-full bg-success ring-4 ring-background flex items-center justify-center z-10"></div>
                    
                    <div class="bg-surface rounded-card p-4 md:p-6 shadow-level-1 hover:shadow-level-2 border border-border/50 relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-3 md:gap-4 transition-all">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-success"></div>
                        
                        <div class="flex-1 flex gap-4">
                            <div class="mt-1 w-10 h-10 rounded-full bg-success/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-success fill">check_circle</span>
                            </div>
                            <div>
                                <div class="flex flex-wrap items-start gap-2 mb-1">
                                    <h3 class="font-headline-sm text-headline-sm text-text-primary font-bold">{{ $task->title }}</h3>
                                    @if($task->course)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-md text-label-md bg-secondary-container text-on-secondary-container">{{ $task->course }}</span>
                                    @endif
                                </div>
                                <p class="font-body-md text-body-md text-text-secondary mb-2 line-clamp-1">{{ $task->description }}</p>
                                <div class="flex items-center gap-4 text-text-secondary font-body-md text-[13px]">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">calendar_today</span> Diselesaikan: {{ $task->completed_at ? $task->completed_at->format('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="shrink-0 flex items-center gap-2 md:flex-col md:items-end">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="font-label-md text-label-md text-primary hover:underline bg-transparent border-0 cursor-pointer">Batalkan Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="py-xl text-center">
            <span class="material-symbols-outlined text-4xl text-text-secondary mb-2 opacity-50">history</span>
            <p class="text-text-secondary font-medium">Belum ada riwayat tugas yang diselesaikan.</p>
        </div>
        @endforelse
        
    </div>
</div>
</div>
@endsection
