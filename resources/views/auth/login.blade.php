@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="bg-surface w-full max-w-[448px] p-lg md:p-xl rounded-card shadow-[0_4px_12px_rgba(0,0,0,0.05)] border border-border">
    <!-- Mobile Logo -->
    <div class="md:hidden flex justify-center mb-lg">
        <img alt="TaskMate Logo" class="w-16 h-16 object-contain bg-primary rounded p-1" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBR9CWGKgAF6nuG8qgmyHlll3qR0VN_iHdg4O31IJI1KlKs0vuZmbAiUtSo9ZKzmOz4oB5nHxNKST6yRjUocaxf-fN1xCa14REfBgrGVJJMQD8EKcHmNxZhpgB6DXU08Dstq5sosa3DKoh8sSuub_39UOYLW6fbMbYHdFB1gKveHDsI-EqraQSEe1p6CUV1_7ovscvoo79teLKA1hbWq1VhXZJNYpYLfywCRmiwv8wBoqMkes6eSZf59kzGhu727wy5IAyj85aSmYY"/>
    </div>
    
    <div class="mb-lg">
        <h2 class="font-headline-md text-headline-md text-text-primary mb-xs font-semibold">Selamat Datang</h2>
        <p class="font-body-md text-body-md text-text-secondary">
            Masuk ke akun kamu untuk mulai mengelola tugas
        </p>
    </div>
    
    @if(session('success'))
        <div class="mb-md p-3 rounded-lg bg-success/10 border border-success/20 text-success text-sm font-medium flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-md p-3 rounded-lg bg-danger/10 border border-danger/20 text-danger text-sm font-medium flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                <span>Gagal Masuk</span>
            </div>
            <ul class="list-disc list-inside ml-6 text-xs mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-md">
        @csrf
        <x-input 
            type="email" 
            name="email" 
            label="Email" 
            icon="mail" 
            placeholder="mahasiswa@kampus.ac.id" 
            required="true"
            value="{{ old('email') }}"
        />
        
        <div>
            <div class="flex justify-between items-center mb-xs">
                <label class="block font-label-md text-label-md text-text-primary uppercase tracking-wide" for="password">Password</label>
                <a class="font-label-md text-label-md text-primary hover:text-primary-container transition-colors" href="#">Lupa Password?</a>
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-sm text-text-secondary">
                    <span class="material-symbols-outlined" data-icon="lock">lock</span>
                </span>
                <input class="w-full pl-[44px] pr-sm py-sm bg-surface border border-outline-variant rounded-[10px] focus:ring-2 focus:ring-secondary focus:border-secondary font-body-md text-body-md text-text-primary transition-shadow" id="password" name="password" placeholder="••••••••" required="" type="password"/>
            </div>
        </div>
        
        <x-button type="submit" variant="primary" fullWidth="true">Masuk</x-button>
    </form>
    
    <!-- Divider -->
    <div class="relative flex items-center py-lg">
        <div class="flex-grow border-t border-border"></div>
        <span class="flex-shrink-0 mx-sm font-label-md text-label-md text-text-secondary uppercase">atau</span>
        <div class="flex-grow border-t border-border"></div>
    </div>
    
    <!-- Register Button -->
    <a href="/register" class="block">
        <x-button type="button" variant="ghost" fullWidth="true">Daftar Sekarang</x-button>
    </a>
</div>
@endsection
