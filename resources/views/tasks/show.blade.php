@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
<div class="max-w-[680px] mx-auto">
    <!-- Back Navigation -->
    <div class="mb-lg">
        <a href="/tasks" class="inline-flex items-center gap-2 text-text-secondary hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-[20px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="font-body-md text-body-md font-medium">Kembali</span>
        </a>
    </div>

    <!-- Alert Banner -->
    <x-deadline-alert count="1" />

    <!-- Detail Card -->
    <article class="bg-surface rounded-card shadow-level-1 p-6 md:p-8 relative overflow-hidden">
        <!-- Status Accent Stripe -->
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-warning"></div>

        <!-- Header Section -->
        <header class="flex flex-col md:flex-row md:items-start justify-between gap-4 border-b border-border pb-6 mb-6">
            <div>
                <h1 class="font-headline-lg-mobile md:font-headline-lg text-text-primary mb-2">Makalah Sistem Pakar & AI</h1>
                <span class="font-body-md text-text-secondary inline-block">Mata Kuliah: Kecerdasan Buatan (CS-401)</span>
            </div>
            <!-- Status Badge -->
            <div class="shrink-0 self-start">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-warning/10 text-warning font-label-md text-label-md uppercase tracking-wider">
                    Sedang Berjalan
                </span>
            </div>
        </header>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-surface-container-low/50 p-4 rounded-lg">
            <div class="flex flex-col gap-1">
                <span class="font-label-md text-label-md text-text-secondary uppercase">Deadline</span>
                <div class="flex items-center gap-2 text-text-primary">
                    <span class="material-symbols-outlined text-[18px] text-warning">calendar_today</span>
                    <span class="font-body-md font-medium text-warning">Jumat, 15 Nov 2026 - 23:59</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <span class="font-label-md text-label-md text-text-secondary uppercase">Prioritas</span>
                <div class="flex items-center gap-2 text-text-primary">
                    <span class="material-symbols-outlined text-[18px] text-danger">flag</span>
                    <span class="font-body-md font-medium">Tinggi</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <span class="font-label-md text-label-md text-text-secondary uppercase">Dibuat Pada</span>
                <div class="flex items-center gap-2 text-text-secondary">
                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                    <span class="font-body-md">Senin, 01 Nov 2026</span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-10">
            <h3 class="font-headline-sm text-headline-sm text-text-primary mb-3">Deskripsi Tugas</h3>
            <div class="prose prose-sm md:prose-base text-text-secondary font-body-lg text-body-lg">
                <p class="mb-4">Buatlah makalah komprehensif mengenai penerapan Sistem Pakar dalam bidang medis. Makalah harus mencakup arsitektur dasar, basis pengetahuan, dan mesin inferensi yang digunakan.</p>
                <ul class="list-disc pl-5 mb-4 space-y-2">
                    <li>Minimal 15 halaman (tidak termasuk daftar pustaka).</li>
                    <li>Format: Times New Roman 12, Spasi 1.5, Margins 4-4-3-3.</li>
                    <li>Gunakan minimal 5 jurnal internasional sebagai referensi (tahun terbit > 2019).</li>
                </ul>
                <p>File dikumpulkan dalam format PDF dengan penamaan: <strong>NIM_Nama_TugasAI.pdf</strong></p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row items-center gap-4 pt-6 border-t border-border">
            <x-button variant="success" icon="check_circle" fullWidth="true" class="md:w-auto !bg-success !text-white hover:!bg-success/90">
                Tandai Selesai
            </x-button>
            <a href="/tasks/1/edit" class="w-full md:w-auto">
                <x-button variant="secondary" icon="edit" fullWidth="true">
                    Edit
                </x-button>
            </a>
            
            <div class="w-full md:w-px md:h-8 bg-border md:mx-2 my-2 md:my-0"></div> <!-- Divider -->
            
            <x-button variant="danger" icon="delete" fullWidth="true" class="md:w-auto">
                Hapus
            </x-button>
        </div>
    </article>
</div>
@endsection
