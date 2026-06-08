@extends('layouts.app')

@section('title', 'Tambah Tugas Baru')

@section('content')
<div class="max-w-[640px] mx-auto">
    <!-- Back Navigation -->
    <div class="mb-md">
        <a href="/tasks" class="inline-flex items-center gap-2 text-text-secondary hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-[20px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="font-body-md text-body-md font-medium">Kembali</span>
        </a>
    </div>

    <div class="mb-lg">
        <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary mb-xs">Tambah Tugas Baru</h1>
        <p class="font-body-md text-body-md text-text-secondary">Masukkan detail tugas untuk ditambahkan ke daftar Anda.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-surface rounded-card shadow-level-1 p-md md:p-lg relative overflow-hidden">
        <!-- Academic Accent Stripe -->
        <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-primary"></div>
        
        <form action="{{ route('tasks.store') }}" method="POST" class="flex flex-col gap-md" x-data="{ subtasks: [''] }">
            @csrf
            <!-- Judul Tugas -->
            <x-input 
                name="title" 
                label="Judul Tugas" 
                placeholder="Contoh: Makalah Sejarah Indonesia" 
                required="true" 
            />

            <!-- Mata Kuliah -->
            <x-input 
                name="course" 
                label="Mata Kuliah" 
                placeholder="Contoh: CS302 - RPL Lanjut" 
            />

            <!-- Deskripsi -->
            <div class="w-full">
                <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="description">Deskripsi</label>
                <textarea class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow resize-y placeholder:text-text-secondary/60" id="description" name="description" placeholder="Detail tambahan tentang tugas ini..." rows="4"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <!-- Deadline -->
                <div class="w-full">
                    <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="deadline">Tenggat Waktu <span class="text-danger">*</span></label>
                    <div class="relative">
                        <!-- Removed custom calendar icon because type="datetime-local" provides its own native icon -->
                        <input class="w-full pl-sm pr-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow cursor-pointer" id="deadline" name="deadline" type="datetime-local" required />
                    </div>
                </div>

                <!-- Status/Priority -->
                <div class="w-full">
                    <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="priority">Prioritas</label>
                    <div class="relative">
                        <select class="w-full pl-sm pr-10 py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow appearance-none cursor-pointer" id="priority" name="priority">
                            <option value="3">Biasa</option>
                            <option value="2" selected>Penting</option>
                            <option value="1">Sangat Penting (Mendesak)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>
            </div>

            <!-- Checklist / Sub-tugas -->
            <div class="w-full">
                <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide">Daftar Sub-tugas (Checklist)</label>
                <div class="space-y-2">
                    <template x-for="(subtask, index) in subtasks" :key="index">
                        <div class="flex gap-2 items-center">
                            <input type="text" x-model="subtasks[index]" name="subtasks[]" placeholder="Contoh: Cari bahan referensi" class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow placeholder:text-text-secondary/60">
                            <button type="button" @click="subtasks.splice(index, 1)" class="p-2 text-text-secondary hover:text-danger transition-colors bg-surface-variant rounded-[10px] shrink-0" x-show="subtasks.length > 1">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>
                        </div>
                    </template>
                </div>
                <button type="button" @click="subtasks.push('')" class="self-start mt-2 text-primary font-label-md hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">add</span> Tambah Sub-tugas
                </button>
            </div>

            <div class="border-t border-border mt-sm pt-md flex justify-end gap-sm items-center">
                <a href="/tasks">
                    <x-button type="button" variant="ghost">Batal</x-button>
                </a>
                <x-button type="submit" variant="primary" icon="save">Simpan Tugas</x-button>
            </div>
        </form>
    </div>
</div>
@endsection
