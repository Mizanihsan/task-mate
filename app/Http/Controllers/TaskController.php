<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subtask;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $now = Carbon::now();
        
        $total = $user->tasks()->count();
        $completed = $user->tasks()->where('status', 'completed')->count();
        $approaching = $user->tasks()->where('status', 'pending')
                            ->whereDate('deadline', '>=', $now)
                            ->whereDate('deadline', '<=', $now->copy()->addDays(3))
                            ->count();
        $overdue = $user->tasks()->where('status', 'pending')
                        ->where('deadline', '<', $now)->count();
        
        // Overall progress logic
        $overallProgress = $total > 0 ? round(($completed / $total) * 100) : 0;
        
        // Urgent tasks: Sort by Priority (tinggi -> menengah -> rendah), then by deadline
        $urgentTasks = $user->tasks()->where('status', 'pending')
            ->orderBy('priority', 'asc')
            ->orderBy('deadline', 'asc')
            ->take(6)
            ->get();
        
        return view('dashboard', compact('total', 'completed', 'approaching', 'overdue', 'urgentTasks', 'overallProgress'));
    }

    public function index(Request $request)
    {
        // ... (sorting by Priority High -> Medium -> Low then Deadline as per QA #7)
        $query = Auth::user()->tasks()->with('subtasks')
                    ->orderBy('priority', 'asc')
                    ->orderBy('deadline');
        
        if ($request->filled('course')) {
            $query->where('course', 'like', '%' . $request->course . '%');
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('deadline', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('deadline', '<=', $request->date_to);
        }
        
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'belum_selesai') {
                $query->where('status', 'pending');
            } elseif ($status === 'selesai') {
                $query->where('status', 'completed');
            }
        }
        
        $tasks = $query->get();
        $courses = Auth::user()->tasks()->whereNotNull('course')->where('course', '!=', '')->distinct()->pluck('course');
        
        return view('tasks.index', compact('tasks', 'courses'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:1,2,3',
            'subtasks' => 'nullable|array',
            'subtasks.*' => 'required|string|max:255',
        ]);
        
        $task = Auth::user()->tasks()->create([
            'title' => $validated['title'],
            'course' => $validated['course'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);
        
        if (!empty($validated['subtasks'])) {
            foreach ($validated['subtasks'] as $subtaskTitle) {
                if(trim($subtaskTitle) !== '') {
                    $task->subtasks()->create(['title' => $subtaskTitle]);
                }
            }
        }
        
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        $task->load('subtasks');
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:1,2,3',
            'subtasks' => 'nullable|array',
            'subtasks.*' => 'required|string|max:255',
        ]);
        
        $task->update([
            'title' => $validated['title'],
            'course' => $validated['course'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'priority' => $validated['priority'],
        ]);
        
        // Sync subtasks
        $task->subtasks()->delete();
        if (!empty($validated['subtasks'])) {
            foreach ($validated['subtasks'] as $subtaskTitle) {
                if(trim($subtaskTitle) !== '') {
                    $task->subtasks()->create(['title' => $subtaskTitle]);
                }
            }
        }
        
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        $task->delete();
        return back()->with('success', 'Tugas dihapus.');
    }

    public function toggleComplete(Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        
        if ($task->status === 'completed') {
            $task->update(['status' => 'pending', 'completed_at' => null]);
        } else {
            $task->update(['status' => 'completed', 'completed_at' => now()]);
        }
        
        return back();
    }
    
    public function toggleSubtask(Subtask $subtask)
    {
        $task = $subtask->task;
        if ($task->user_id !== Auth::id()) abort(403);
        
        $subtask->update(['is_completed' => !$subtask->is_completed]);
        return back();
    }
    
    public function updateSubtasks(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        
        $completedSubtaskIds = $request->input('completed_subtasks', []);
        
        if (!empty($completedSubtaskIds)) {
            $task->subtasks()->whereIn('id', $completedSubtaskIds)->update(['is_completed' => true]);
        }
        
        $task->subtasks()->whereNotIn('id', $completedSubtaskIds)->update(['is_completed' => false]);
        
        return back()->with('success', 'Progress diperbarui.');
    }
    
    public function history(Request $request)
    {
        $query = Auth::user()->tasks()->where('status', 'completed')->orderBy('completed_at', 'desc');
        
        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }
        
        if ($request->filled('period')) {
            $period = $request->period;
            $now = Carbon::now();
            if ($period === 'bulan_ini') {
                $query->whereMonth('completed_at', $now->month)->whereYear('completed_at', $now->year);
            } elseif ($period === 'bulan_lalu') {
                $lastMonth = $now->copy()->subMonth();
                $query->whereMonth('completed_at', $lastMonth->month)->whereYear('completed_at', $lastMonth->year);
            }
        }
        
        $tasks = $query->get()->groupBy(function($date) {
            return Carbon::parse($date->completed_at)->format('F Y'); 
        });
        
        $courses = Auth::user()->tasks()->whereNotNull('course')->where('course', '!=', '')->distinct()->pluck('course');
        
        return view('tasks.history', compact('tasks', 'courses'));
    }
}
