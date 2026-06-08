<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');
    Route::get('/tasks/history', [TaskController::class, 'history'])->name('tasks.history');
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');
    Route::patch('/tasks/{task}/subtasks', [TaskController::class, 'updateSubtasks'])->name('tasks.subtasks.update');
    Route::patch('/subtasks/{subtask}/toggle', [TaskController::class, 'toggleSubtask'])->name('subtasks.toggle');
});
