@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1024px] mx-auto w-full">
<!-- TopAppBar -->
<header class="bg-surface md:bg-transparent text-primary md:text-text-primary fixed md:static top-0 right-0 left-0 h-14 md:h-auto shadow-sm md:shadow-none flex items-center justify-between px-4 md:px-0 w-full z-30 mb-lg">
    <div class="flex items-center gap-sm">
        <!-- Mobile Brand Title -->
        <h2 class="font-headline-md text-headline-md font-bold text-primary md:hidden">TaskMate</h2>
        
        <!-- Desktop Header Title -->
        <div class="hidden md:block">
            <h2 class="font-headline-lg text-headline-lg text-text-primary mb-1">Halo, {{ Auth::user()->name }} 👋</h2>
            <p class="font-body-lg text-body-lg text-text-secondary">Siap untuk menyelesaikan tugas hari ini? Ini ringkasanmu untuk {{ now()->isoFormat('D MMMM Y') }}.</p>
        </div>
    </div>
    <div class="flex items-center gap-xs">
        <a href="{{ route('tasks.create') }}">
            <x-button variant="primary" icon="add" class="hidden md:flex">Tugas Baru</x-button>
        </a>
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
    <!-- Mobile Welcome Message -->
    <div class="md:hidden mb-lg">
        <h2 class="font-headline-md text-headline-md text-text-primary mb-1">Halo, {{ Auth::user()->name }} 👋</h2>
        <p class="font-body-md text-body-md text-text-secondary">Siap untuk menyelesaikan tugas hari ini?</p>
    </div>

    <!-- Progress Bar Section -->
    <div class="bg-surface rounded-card shadow-level-1 p-md md:p-lg border border-border/50 mb-xl flex flex-col md:flex-row items-center gap-md">
        <!-- Circular Progress Graphic -->
        <div class="relative w-24 h-24 flex-shrink-0">
            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                <!-- Background Circle -->
                <path class="text-surface-variant" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.8"/>
                <!-- Progress Circle -->
                <path class="text-primary" stroke-dasharray="{{ $overallProgress }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.8" stroke-linecap="round"/>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-xl font-bold text-text-primary">{{ $overallProgress }}%</span>
            </div>
        </div>
        
        <!-- Progress Text -->
        <div class="text-center md:text-left flex-1">
            <h3 class="font-headline-md text-headline-md text-primary mb-1">Progress Keseluruhan</h3>
            <p class="text-body-md text-text-secondary mb-2">Anda telah menyelesaikan <strong>{{ $completed }}</strong> dari <strong>{{ $total }}</strong> tugas yang Anda miliki.</p>
            @if($overallProgress == 100 && $total > 0)
                <span class="inline-flex items-center gap-1 text-sm font-medium text-success bg-success/10 px-3 py-1 rounded-full"><span class="material-symbols-outlined text-[16px]">celebration</span> Kerja luar biasa, semua tugas selesai!</span>
            @elseif($overallProgress >= 50)
                <span class="inline-flex items-center gap-1 text-sm font-medium text-primary bg-primary/10 px-3 py-1 rounded-full"><span class="material-symbols-outlined text-[16px]">trending_up</span> Semangat, lebih dari separuh jalan!</span>
            @else
                <span class="inline-flex items-center gap-1 text-sm font-medium text-warning bg-warning/10 px-3 py-1 rounded-full"><span class="material-symbols-outlined text-[16px]">pace</span> Yuk mulai kerjakan cicilan tugasmu!</span>
            @endif
        </div>
    </div>

    <!-- Stats Row -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-xl">
        <x-stat-card 
            color="primary" 
            icon="assignment" 
            label="Total Tugas" 
            value="{{ $total }}" 
        />
        <x-stat-card 
            color="success" 
            icon="task_alt" 
            label="Tugas Selesai" 
            value="{{ $completed }}" 
        />
        <x-stat-card 
            color="warning" 
            icon="schedule" 
            label="Menunggu Deadline" 
            value="{{ $approaching }}" 
        />
        <x-stat-card 
            color="danger" 
            icon="warning" 
            label="Terlambat" 
            value="{{ $overdue }}" 
        />
    </section>

    <!-- Tasks Approaching Deadline -->
    <section>
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-headline-md text-headline-md text-text-primary">Tugas Mendekati Deadline</h3>
            <a class="font-body-md text-body-md text-primary hover:text-primary-container font-medium flex items-center gap-1" href="{{ route('tasks.index') }}">
                Lihat Semua <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-gutter">
            @forelse($urgentTasks as $task)
                @php
                    $isOverdue = $task->deadline < now();
                    $isToday = $task->deadline->isToday();
                    $isApproaching = $task->deadline->diffInDays(now()) <= 3;
                    
                    if ($isOverdue) $priority = 'urgent';
                    elseif ($isToday || $isApproaching || $task->priority === 1) $priority = 'warning';
                    else $priority = 'safe';
                @endphp
                <x-task-card :task="$task" :priority="$priority" layout="grid" />
            @empty
                <div class="col-span-full py-xl text-center bg-surface border border-dashed border-border rounded-card">
                    <span class="material-symbols-outlined text-4xl text-text-secondary mb-2 opacity-50">task_alt</span>
                    <p class="text-text-secondary font-medium">Yeay! Tidak ada tugas mendesak saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
</div>
@endsection
