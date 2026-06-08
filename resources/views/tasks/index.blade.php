@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('content')
<div class="max-w-[1024px] mx-auto w-full">
<!-- TopAppBar (matches Dashboard) -->
<header class="bg-surface md:bg-transparent text-primary md:text-text-primary fixed md:static top-0 right-0 left-0 h-14 md:h-auto shadow-sm md:shadow-none flex items-center justify-between px-4 md:px-0 w-full z-30 mb-lg">
    <div class="flex items-center gap-sm">
        <!-- Mobile Brand Title -->
        <h2 class="font-headline-md text-headline-md font-bold text-primary md:hidden">TaskMate</h2>
        
        <!-- Desktop Header Title -->
        <div class="hidden md:block">
            <h2 class="font-headline-lg text-headline-lg text-text-primary mb-1">Tugas Saya</h2>
            <p class="font-body-lg text-body-lg text-text-secondary">Kelola dan pantau semua tugas akademik Anda.</p>
        </div>
    </div>
    <div class="flex items-center gap-xs">
        <a href="{{ route('tasks.create') }}">
            <x-button variant="primary" icon="add" class="hidden md:flex">Tambah Tugas</x-button>
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
    <!-- Mobile Welcome Message (matches Dashboard pattern) -->
    <div class="md:hidden mb-md">
        <h2 class="font-headline-md text-headline-md text-text-primary mb-1">Tugas Saya</h2>
        <p class="font-body-md text-body-md text-text-secondary">Kelola dan pantau semua tugas akademik Anda.</p>
    </div>
    <!-- Filters -->
    <form action="{{ route('tasks.index') }}" method="GET" class="bg-surface rounded-card p-3 sm:p-sm shadow-level-1 mb-md sm:mb-lg flex flex-col gap-3 sm:gap-sm border border-border/50" x-data="{ showFilters: {{ request('date_from') || request('date_to') || request('course') ? 'true' : 'false' }} }">
        <!-- Course Dropdown -->
        <div class="relative w-full">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-[20px]">book</span>
            <select name="course" onchange="this.form.submit()" class="w-full pl-10 pr-10 py-2.5 sm:py-2 bg-background border border-outline-variant rounded-lg text-body-md focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/20 transition-all appearance-none cursor-pointer">
                <option value="">Semua Mata Kuliah</option>
                @foreach($courses as $c)
                    <option value="{{ $c }}" {{ request('course') == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none text-[20px]">expand_more</span>
        </div>
        
        <!-- Pill Tabs -->
        <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto hide-scrollbar pb-1">
            <input type="hidden" name="status" id="status-input" value="{{ request('status', 'semua') }}">
            
            <button type="submit" onclick="document.getElementById('status-input').value='semua'" class="{{ request('status', 'semua') === 'semua' ? 'bg-secondary-container text-on-secondary-container border-transparent' : 'bg-surface text-text-secondary border-outline-variant' }} whitespace-nowrap px-3.5 py-1.5 rounded-full font-label-md text-[12px] sm:text-label-md transition-colors border">
                Semua
            </button>
            <button type="submit" onclick="document.getElementById('status-input').value='belum_selesai'" class="{{ request('status') === 'belum_selesai' ? 'bg-secondary-container text-on-secondary-container border-transparent' : 'bg-surface text-text-secondary border-outline-variant' }} whitespace-nowrap px-3.5 py-1.5 rounded-full font-label-md text-[12px] sm:text-label-md transition-colors border">
                Belum Selesai
            </button>
            <button type="submit" onclick="document.getElementById('status-input').value='selesai'" class="{{ request('status') === 'selesai' ? 'bg-secondary-container text-on-secondary-container border-transparent' : 'bg-surface text-text-secondary border-outline-variant' }} whitespace-nowrap px-3.5 py-1.5 rounded-full font-label-md text-[12px] sm:text-label-md transition-colors border">
                Selesai
            </button>
            <button type="button" @click="showFilters = !showFilters" :class="showFilters ? 'bg-surface-variant text-text-primary' : 'bg-surface text-text-secondary'" class="whitespace-nowrap px-3 py-1.5 rounded-full font-label-md text-[12px] sm:text-label-md transition-colors border border-outline-variant flex items-center gap-1 ml-auto">
                <span class="material-symbols-outlined text-[16px]">filter_list</span>
                Filter
            </button>
        </div>
        
        <!-- Expandable Advanced Filters -->
        <div x-show="showFilters" x-transition class="pt-3 border-t border-border grid grid-cols-1 sm:grid-cols-2 gap-3 items-end" style="display: none;">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-text-secondary uppercase">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-sm py-2.5 rounded-lg border border-border bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:border-secondary transition-all" />
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-text-secondary uppercase">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-sm py-2.5 rounded-lg border border-border bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:border-secondary transition-all" />
            </div>
            <div class="sm:col-span-2 flex justify-end">
                <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-primary text-on-primary rounded-lg font-label-md hover:bg-primary/90 transition-colors">Terapkan Filter</button>
            </div>
        </div>
    </form>

    <!-- Task List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-gutter">
        @forelse($tasks as $task)
            @php
                $isOverdue = $task->deadline < now() && $task->status !== 'completed';
                $isToday = $task->deadline->isToday();
                $isApproaching = $task->deadline->diffInDays(now()) <= 3;
                
                if ($isOverdue) $priority = 'urgent';
                elseif ($isToday || $isApproaching || $task->priority === 1) $priority = 'warning';
                else $priority = 'safe';
            @endphp
            <x-task-card :task="$task" :priority="$priority" :status="$task->status" layout="grid" />
        @empty
            <div class="col-span-full py-xl text-center bg-surface border border-dashed border-border rounded-card">
                <span class="material-symbols-outlined text-4xl text-text-secondary mb-2 opacity-50">task_alt</span>
                <p class="text-text-secondary font-medium mb-4">Yeay! Tidak ada tugas yang ditemukan.</p>
                <a href="{{ route('tasks.create') }}">
                    <x-button variant="primary" icon="add">Tambah Tugas Baru</x-button>
                </a>
            </div>
        @endforelse
    </div>
</div>
</div>

<!-- Create Task Modal (outside main wrapper to prevent layout issues) -->
<x-modal name="create-task" maxWidth="xl">
    <div class="p-4 sm:p-lg">
        <div class="flex items-start justify-between mb-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-text-primary mb-1">Tambah Tugas Baru </h2>
                <p class="font-body-md text-body-md text-text-secondary">Buat tugas baru dan atur pengingat .</p>
            </div>
            <button x-on:click="$dispatch('close-modal', 'create-task')" class="p-1 rounded-full text-text-secondary hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('tasks.store') }}" method="POST" class="flex flex-col gap-4" x-data="{ subtasks: [''] }">
            @csrf
            
            <x-input name="title" label="Judul Tugas" placeholder="Contoh: Makalah Sejarah Indonesia" required="true" />
            <x-input name="course" label="Mata Kuliah" placeholder="Contoh: CS-101" />
            
            <div class="w-full">
                <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="modal-description">Deskripsi</label>
                <textarea class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow resize-y" id="modal-description" name="description" rows="2"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="w-full">
                    <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="modal-deadline">Tenggat Waktu <span class="text-danger">*</span></label>
                    <input class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow cursor-pointer" id="modal-deadline" name="deadline" type="datetime-local" required />
                </div>
                <div class="w-full">
                    <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="modal-priority">Prioritas</label>
                    <div class="relative">
                        <select class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow appearance-none cursor-pointer" id="modal-priority" name="priority">
                            <option value="3">Biasa</option>
                            <option value="2">Penting</option>
                            <option value="1">Sangat Penting (Mendesak)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>
            </div>

            <div class="w-full mt-2">
                <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide">Sub-tugas (Checklist)</label>
                <div class="space-y-2 max-h-[150px] overflow-y-auto pr-2">
                    <template x-for="(subtask, index) in subtasks" :key="index">
                        <div class="flex gap-2 items-center">
                            <input type="text" x-model="subtasks[index]" name="subtasks[]" placeholder="Sub-tugas..." class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow">
                            <button type="button" @click="subtasks.splice(index, 1)" class="p-2 text-text-secondary hover:text-danger bg-surface-variant rounded-[10px] shrink-0" x-show="subtasks.length > 1">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                            </button>
                        </div>
                    </template>
                </div>
                <button type="button" @click="subtasks.push('')" class="self-start mt-1 text-primary font-label-md hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">add</span> Tambah Sub-tugas
                </button>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 pt-4 mt-2 border-t border-border">
                <x-button variant="ghost" type="button" x-on:click="$dispatch('close-modal', 'create-task')">Batal</x-button>
                <x-button variant="primary" type="submit">Simpan Tugas</x-button>
            </div>
        </form>
    </div>
</x-modal>

@endsection
