<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'title',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
