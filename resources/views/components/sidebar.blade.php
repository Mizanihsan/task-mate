<aside class="hidden md:flex w-[240px] h-screen fixed left-0 top-0 bg-primary-container shadow-sm flex-col gap-sm p-sm z-20">
    <div class="flex items-center gap-3 px-3 py-4 mb-4">
        <img alt="TaskMate Logo" class="w-8 h-8 rounded bg-white p-0.5 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBR9CWGKgAF6nuG8qgmyHlll3qR0VN_iHdg4O31IJI1KlKs0vuZmbAiUtSo9ZKzmOz4oB5nHxNKST6yRjUocaxf-fN1xCa14REfBgrGVJJMQD8EKcHmNxZhpgB6DXU08Dstq5sosa3DKoh8sSuub_39UOYLW6fbMbYHdFB1gKveHDsI-EqraQSEe1p6CUV1_7ovscvoo79teLKA1hbWq1VhXZJNYpYLfywCRmiwv8wBoqMkes6eSZf59kzGhu727wy5IAyj85aSmYY"/>
        <div>
            <h1 class="font-headline-md text-headline-md font-bold text-white leading-tight">TaskMate</h1>
            <p class="font-label-md text-label-md text-on-primary-container/80">Student Portal</p>
        </div>
    </div>
    <nav class="flex flex-col gap-1 flex-1">
        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 {{ request()->is('dashboard') ? 'bg-white/10 text-white font-bold' : 'text-on-primary-container/80 hover:text-white hover:bg-white/5' }} rounded-lg duration-200 ease-in-out group">
            <span class="material-symbols-outlined {{ request()->is('dashboard') ? 'icon-fill' : '' }}">dashboard</span>
            <span class="font-body-md text-body-md {{ request()->is('dashboard') ? '' : 'group-hover:font-medium' }}">Dashboard</span>
        </a>
        <a href="/tasks" class="flex items-center gap-3 px-3 py-2 {{ request()->is('tasks') ? 'bg-white/10 text-white font-bold' : 'text-on-primary-container/80 hover:text-white hover:bg-white/5' }} rounded-lg duration-200 ease-in-out group">
            <span class="material-symbols-outlined {{ request()->is('tasks') ? 'icon-fill' : '' }}">assignment</span>
            <span class="font-body-md text-body-md {{ request()->is('tasks') ? '' : 'group-hover:font-medium' }}">Tugas Saya</span>
        </a>
        <a href="/tasks/create" class="flex items-center gap-3 px-3 py-2 {{ request()->is('tasks/create') ? 'bg-white/10 text-white font-bold' : 'text-on-primary-container/80 hover:text-white hover:bg-white/5' }} rounded-lg duration-200 ease-in-out group">
            <span class="material-symbols-outlined {{ request()->is('tasks/create') ? 'icon-fill' : '' }}">add_circle</span>
            <span class="font-body-md text-body-md {{ request()->is('tasks/create') ? '' : 'group-hover:font-medium' }}">Tambah Tugas</span>
        </a>
        <a href="/tasks/history" class="flex items-center gap-3 px-3 py-2 {{ request()->is('tasks/history') ? 'bg-white/10 text-white font-bold' : 'text-on-primary-container/80 hover:text-white hover:bg-white/5' }} rounded-lg duration-200 ease-in-out group">
            <span class="material-symbols-outlined {{ request()->is('tasks/history') ? 'icon-fill' : '' }}">history</span>
            <span class="font-body-md text-body-md {{ request()->is('tasks/history') ? '' : 'group-hover:font-medium' }}">Riwayat</span>
        </a>
        <!--<a href="/settings" class="flex items-center gap-3 px-3 py-2 text-on-primary-container/80 hover:text-white hover:bg-white/5 rounded-lg duration-200 ease-in-out group mt-auto">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-body-md text-body-md group-hover:font-medium">Pengaturan</span>
        </a>-->
    </nav>
    <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between px-3">
        <div class="flex items-center gap-3 w-full truncate">
            <div class="w-10 h-10 rounded-full border-2 border-white/20 bg-primary flex items-center justify-center text-white font-bold shrink-0">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex flex-col truncate pr-2">
                <span class="font-body-md text-body-md text-white font-medium truncate">{{ Auth::user()->name }}</span>
                <span class="font-label-md text-[10px] text-on-primary-container/70 truncate">{{ Auth::user()->email }}</span>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="shrink-0">
            @csrf
            <button type="submit" class="text-on-primary-container/80 hover:text-white flex items-center justify-center p-1 rounded hover:bg-white/10 cursor-pointer bg-transparent border-0">
                <span class="material-symbols-outlined text-[20px]">logout</span>
            </button>
        </form>
    </div>
</aside>
