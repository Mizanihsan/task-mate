@props([
    'task' => null,
    'status' => 'pending', // pending, completed
    'priority' => 'safe', // urgent, warning, safe
    'layout' => 'row', // row, grid
])

@php
    $isObject = is_object($task);
    
    $borderColor = $isObject ? $task->priority_color_class : match($priority) {
        'urgent' => 'bg-danger',
        'warning' => 'bg-warning',
        'safe' => 'bg-success',
        default => 'bg-primary'
    };

    
    $title = $isObject ? $task->title : ($task['title'] ?? 'Task Title');
    $description = $isObject ? $task->description : ($task['description'] ?? '');
    $course = $isObject ? $task->course : ($task['course'] ?? null);
    
    // Format deadline
    if ($isObject && $task->deadline) {
        $deadlineRaw = clone $task->deadline;
        if ($deadlineRaw->isToday()) $deadlineText = 'Hari Ini, ' . $deadlineRaw->format('H:i');
        elseif ($deadlineRaw->isTomorrow()) $deadlineText = 'Besok, ' . $deadlineRaw->format('H:i');
        elseif ($deadlineRaw->isPast()) $deadlineText = 'Terlambat (' . $deadlineRaw->format('d M') . ')';
        else $deadlineText = $deadlineRaw->format('d M Y, H:i');
    } else {
        $deadlineText = $task['deadline'] ?? 'No Deadline';
    }
    
    $isCompleted = $isObject ? ($task->status === 'completed') : ($status === 'completed');
    $cardClass = $isCompleted ? 'bg-surface/60 opacity-80' : 'bg-surface hover:-translate-y-[2px]';
    $titleStyle = $isCompleted ? 'text-text-secondary line-through' : 'text-text-primary group-hover:text-primary transition-colors';
    
    // Determine flex layout classes
    $containerFlex = $layout === 'row' 
        ? 'flex flex-col sm:flex-row sm:items-center justify-between' 
        : 'flex flex-col h-full';
        
    $actionContainerFlex = $layout === 'row'
        ? 'mt-4 sm:mt-0 flex flex-wrap items-center gap-2 self-end sm:self-auto border-t sm:border-t-0 border-border pt-3 sm:pt-0 w-full sm:w-auto justify-end'
        : 'mt-auto pt-3 sm:pt-4 border-t border-surface-variant flex justify-between items-center w-full';
@endphp

<div class="{{ $cardClass }} rounded-card shadow-level-1 hover:shadow-level-2 transition-all relative overflow-hidden p-3 sm:p-md {{ $containerFlex }} border border-border/50 group">
    <!-- Accent Stripe -->
    <div class="absolute left-0 top-0 bottom-0 w-[4px] {{ $borderColor }}"></div>
    
    @if($layout === 'grid')
        <!-- GRID LAYOUT (Dashboard) -->
        <div class="flex-1 pl-xs flex flex-col">
            <div class="flex justify-between items-start mb-3">
                @if($isCompleted)
                    <span class="bg-success/10 text-success font-label-md text-label-md px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">task_alt</span> Selesai
                    </span>
                @else
                    @php
                        $badgeColor = $priority === 'urgent' ? 'text-danger bg-danger/10' : ($priority === 'warning' ? 'text-warning bg-warning/10' : 'text-success bg-success/10');
                        $badgeIcon = $priority === 'urgent' ? 'timer' : ($priority === 'warning' ? 'event' : 'event_upcoming');
                    @endphp
                    <span class="{{ $badgeColor }} font-label-md text-label-md px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">{{ $badgeIcon }}</span> {{ $deadlineText }}
                    </span>
                @endif
            </div>
            
            <h4 class="font-headline-sm text-[16px] sm:text-headline-sm {{ $titleStyle }} mb-1 line-clamp-2">{{ $title }}</h4>
            <p class="font-body-md text-[13px] sm:text-body-md text-text-secondary mb-3 sm:mb-4 flex items-center gap-1.5 line-clamp-2">
                @if($course)
                    <span class="material-symbols-outlined text-[16px]">menu_book</span> {{ $course }}
                @else
                    {{ $description }}
                @endif
            </p>
            
            <!-- Progress Subtasks (Grid) -->
            @if($isObject && $task->subtasks && $task->subtasks->count() > 0)
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1 text-xs text-text-secondary">
                    <span>Progress Sub-tugas</span>
                    <span>{{ $task->progress }}%</span>
                </div>
                <div class="w-full bg-surface-variant rounded-full h-1.5">
                    <div class="bg-primary h-1.5 rounded-full" style="width: {{ $task->progress }}%"></div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="{{ $actionContainerFlex }}">
            @if($isObject)
                <button type="button" x-data x-on:click="$dispatch('open-modal', 'detail-task-{{ $task->id }}')" class="font-label-md text-[11px] sm:text-label-md text-primary hover:underline shrink-0 bg-transparent border-0 cursor-pointer mr-auto flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">fact_check</span> <span class="hidden sm:inline">Update</span> Progress
                </button>
                
                <div class="flex items-center gap-1">
                    @if(!$isCompleted)
                    <button type="button" x-data x-on:click="$dispatch('open-modal', 'edit-task-{{ $task->id }}')" aria-label="Edit Tugas" class="p-1.5 text-text-secondary hover:text-primary hover:bg-surface-container-low rounded-full transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </button>
                    @endif
                    
                    <button type="button" x-data x-on:click="$dispatch('open-modal', 'delete-task-{{ $task->id }}')" aria-label="Hapus Tugas" class="p-1.5 text-text-secondary hover:text-danger hover:bg-error-container/30 rounded-full transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                    
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        @if(!$isCompleted)
                        <button type="submit" aria-label="Tandai Selesai" class="p-1.5 text-text-secondary hover:text-success hover:bg-success/10 rounded-full transition-colors flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        </button>
                        @else
                        <button type="submit" aria-label="Batalkan Selesai" class="p-1.5 text-text-secondary hover:text-primary hover:bg-primary/10 rounded-full transition-colors flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">restore</span>
                        </button>
                        @endif
                    </form>
                </div>
            @endif
        </div>
    @else
        <!-- ROW LAYOUT (List View) -->
        <div class="flex-1 pl-2 sm:pl-xs flex flex-col min-w-0">
            <div class="flex items-start justify-between gap-2 mb-1">
                <h3 class="font-headline-sm text-[16px] sm:text-headline-sm {{ $titleStyle }} truncate">{{ $title }}</h3>
                
                @if($isCompleted)
                    <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider h-fit mt-0.5 flex items-center gap-1 shrink-0">
                        <span class="material-symbols-outlined text-[12px] fill">check_circle</span> Selesai
                    </span>
                @else
                    @if($priority === 'urgent')
                        <span class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider h-fit mt-0.5 shrink-0">Urgent</span>
                    @endif
                @endif
            </div>
            
            @if($description)
            <p class="font-body-md text-[13px] sm:text-body-md text-text-secondary mb-2 sm:mb-3 w-full {{ $isCompleted ? 'line-clamp-1' : 'line-clamp-2' }}">
                {{ $description }}
            </p>
            @endif
            
            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[12px] sm:text-sm mb-3 sm:mb-4">
                <div class="flex items-center gap-1 {{ $isCompleted ? 'text-text-secondary line-through' : ($priority === 'urgent' ? 'text-danger font-medium' : ($priority === 'warning' ? 'text-warning font-medium' : 'text-text-secondary')) }}">
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px]">{{ $isCompleted ? 'calendar_today' : ($priority === 'urgent' ? 'schedule' : 'calendar_today') }}</span>
                    <span>{{ $deadlineText }}</span>
                </div>
                @if($course)
                <div class="flex items-center gap-1 text-text-secondary">
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px]">book</span>
                    <span>{{ $course }}</span>
                </div>
                @endif
            </div>
            
            <!-- Progress Subtasks (Row) -->
            @if($isObject && $task->subtasks && $task->subtasks->count() > 0)
            <div class="mb-2 w-full max-w-sm">
                <div class="flex justify-between items-center mb-1 text-[11px] sm:text-xs text-text-secondary">
                    <span>Progress ({{ $task->subtasks->where('is_completed', true)->count() }}/{{ $task->subtasks->count() }})</span>
                    <span>{{ $task->progress }}%</span>
                </div>
                <div class="w-full bg-surface-variant rounded-full h-1.5">
                    <div class="bg-primary h-1.5 rounded-full transition-all" style="width: {{ $task->progress }}%"></div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Actions -->
        <div class="mt-3 sm:mt-0 flex items-center gap-1.5 sm:gap-2 self-end sm:self-auto border-t sm:border-t-0 border-border pt-3 sm:pt-0 w-full sm:w-auto justify-end">
            @if($isObject)
                <button type="button" x-data x-on:click="$dispatch('open-modal', 'detail-task-{{ $task->id }}')" class="flex items-center gap-1 px-2.5 py-1.5 text-[12px] sm:text-label-md text-primary hover:bg-primary/5 rounded-lg transition-colors font-medium bg-transparent border-0 cursor-pointer sm:hidden">
                    <span class="material-symbols-outlined text-[16px]">fact_check</span> Progress
                </button>

                @if(!$isCompleted)
                <button type="button" x-data x-on:click="$dispatch('open-modal', 'edit-task-{{ $task->id }}')" aria-label="Edit Tugas" class="p-2 text-text-secondary hover:text-primary hover:bg-surface-container-low rounded-full transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                </button>
                @endif
                
                <button type="button" x-data x-on:click="$dispatch('open-modal', 'delete-task-{{ $task->id }}')" aria-label="Hapus Tugas" class="p-2 text-text-secondary hover:text-danger hover:bg-error-container/30 rounded-full transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                </button>
                
                <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    @if(!$isCompleted)
                    <button type="submit" class="bg-surface border border-outline-variant text-text-secondary hover:border-success hover:text-success hover:bg-success/5 font-label-md text-[11px] sm:text-label-md px-3 sm:px-4 py-1.5 rounded-lg transition-colors flex items-center gap-1 whitespace-nowrap">
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">check_circle</span>
                        <span class="hidden sm:inline">Tandai Selesai</span>
                        <span class="sm:hidden">Selesai</span>
                    </button>
                    @else
                    <button type="submit" class="bg-surface border border-outline-variant text-text-secondary hover:border-primary hover:text-primary hover:bg-primary/5 font-label-md text-[11px] sm:text-label-md px-3 sm:px-4 py-1.5 rounded-lg transition-colors flex items-center gap-1 whitespace-nowrap">
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">restore</span>
                        <span class="hidden sm:inline">Batalkan Selesai</span>
                        <span class="sm:hidden">Batalkan</span>
                    </button>
                    @endif
                </form>
            @endif
        </div>
    @endif
</div>

<!-- Modals -->
@if($isObject)
<!-- Detail Modal -->
<x-modal name="detail-task-{{ $task->id }}" maxWidth="lg">
    <div class="p-4 sm:p-lg">
        <div class="flex items-start justify-between mb-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-text-primary mb-1">{{ $task->title }}</h2>
                @if($task->course)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full font-label-md text-[10px] bg-secondary-container text-on-secondary-container">
                    <span class="material-symbols-outlined text-[12px] mr-1">book</span> {{ $task->course }}
                </span>
                @endif
            </div>
            <button x-on:click="$dispatch('close-modal', 'detail-task-{{ $task->id }}')" class="p-1 rounded-full text-text-secondary hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <p class="font-body-md text-body-md text-text-secondary mb-lg">{{ $task->description ?: 'Tidak ada deskripsi.' }}</p>
        
        @if($task->subtasks->count() > 0)
        <form action="{{ route('tasks.subtasks.update', $task) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-lg">
                <h3 class="font-label-md text-label-md uppercase tracking-wider text-text-secondary mb-sm">Checklist Sub-tugas</h3>
                <div class="space-y-2">
                    @foreach($task->subtasks as $subtask)
                    <label class="flex items-center p-3 rounded-lg border border-border/50 bg-surface/50 hover:bg-surface-variant/30 transition-colors cursor-pointer group">
                        <input type="checkbox" name="completed_subtasks[]" value="{{ $subtask->id }}" {{ $subtask->is_completed ? 'checked' : '' }} class="peer w-5 h-5 rounded border-outline text-primary focus:ring-primary cursor-pointer mt-0.5 mr-3">
                        <span class="font-body-md text-body-md peer-checked:line-through peer-checked:text-text-secondary text-text-primary transition-all">
                            {{ $subtask->title }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
            
            <div class="flex justify-end gap-2 pt-4 border-t border-border">
                <x-button variant="ghost" type="button" x-on:click="$dispatch('close-modal', 'detail-task-{{ $task->id }}')">Batal</x-button>
                <x-button variant="primary" type="submit">Simpan Progress</x-button>
            </div>
        </form>
        @else
        <div class="flex justify-end gap-2 pt-4 border-t border-border">
            <x-button variant="ghost" type="button" x-on:click="$dispatch('close-modal', 'detail-task-{{ $task->id }}')">Tutup</x-button>
        </div>
        @endif
    </div>
</x-modal>

<!-- Delete Modal -->
<x-modal name="delete-task-{{ $task->id }}" maxWidth="sm">
    <div class="p-4 sm:p-lg">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="w-12 h-12 rounded-full bg-danger/10 text-danger flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[24px]">warning</span>
            </div>
            <h2 class="font-headline-sm text-headline-sm text-text-primary mb-2">Hapus Tugas?</h2>
            <p class="font-body-md text-body-md text-text-secondary">Apakah Anda yakin ingin menghapus tugas <strong>"{{ $task->title }}"</strong>? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        
        <div class="flex justify-center gap-3 w-full">
            <x-button variant="ghost" type="button" x-on:click="$dispatch('close-modal', 'delete-task-{{ $task->id }}')" class="flex-1">Batal</x-button>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <x-button variant="primary" type="submit" class="w-full bg-danger hover:bg-danger/90">Hapus</x-button>
            </form>
        </div>
    </div>
</x-modal>

<!-- Edit Modal -->
<x-modal name="edit-task-{{ $task->id }}" maxWidth="xl">
    <div class="p-4 sm:p-lg">
        <div class="flex items-start justify-between mb-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-text-primary mb-1">Edit Tugas</h2>
                <p class="font-body-md text-body-md text-text-secondary">Ubah detail tugas sesuai kebutuhan Anda.</p>
            </div>
            <button x-on:click="$dispatch('close-modal', 'edit-task-{{ $task->id }}')" class="p-1 rounded-full text-text-secondary hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('tasks.update', $task) }}" method="POST" class="flex flex-col gap-4" x-data="{ subtasks: {{ $task->subtasks->count() > 0 ? Js::from($task->subtasks->pluck('title')->toArray()) : "['']" }} }">
            @csrf
            @method('PUT')
            
            <x-input name="title" label="Judul Tugas" value="{{ $task->title }}" required="true" />
            <x-input name="course" label="Mata Kuliah" value="{{ $task->course }}" />
            
            <div class="w-full">
                <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="description_{{ $task->id }}">Deskripsi</label>
                <textarea class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow resize-y" id="description_{{ $task->id }}" name="description" rows="2">{{ $task->description }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="w-full">
                    <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="deadline_{{ $task->id }}">Tenggat Waktu <span class="text-danger">*</span></label>
                    <input class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow cursor-pointer" id="deadline_{{ $task->id }}" name="deadline" type="datetime-local" value="{{ $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '' }}" required />
                </div>
                <div class="w-full">
                    <label class="block font-label-md text-label-md text-text-primary mb-xs uppercase tracking-wide" for="priority_{{ $task->id }}">Prioritas</label>
                    <div class="relative">
                        <select class="w-full px-sm py-sm rounded-[10px] border border-outline-variant bg-surface text-text-primary font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary transition-shadow appearance-none cursor-pointer" id="priority_{{ $task->id }}" name="priority">
                            <option value="rendah" {{ $task->priority === 'rendah' ? 'selected' : '' }}>Biasa</option>
                            <option value="menengah" {{ $task->priority === 'menengah' ? 'selected' : '' }}>Penting</option>
                            <option value="tinggi" {{ $task->priority === 'tinggi' ? 'selected' : '' }}>Sangat Penting (Mendesak)</option>
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
                <x-button variant="ghost" type="button" x-on:click="$dispatch('close-modal', 'edit-task-{{ $task->id }}')">Batal</x-button>
                <x-button variant="primary" type="submit">Simpan Perubahan</x-button>
            </div>
        </form>
    </div>
</x-modal>
@endif
