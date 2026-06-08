<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'course',
        'deadline',
        'priority',
        'status',
        'completed_at',
    ];

    public const PRIORITY_HIGH = 1;
    public const PRIORITY_MEDIUM = 2;
    public const PRIORITY_LOW = 3;

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime',
        'priority' => 'integer',
    ];

    public function getPriorityLabelAttribute()
    {
        return match ($this->priority) {
            self::PRIORITY_HIGH => 'tinggi',
            self::PRIORITY_MEDIUM => 'menengah',
            self::PRIORITY_LOW => 'rendah',
            default => 'menengah',
        };
    }

    public function getPriorityColorClassAttribute()
    {
        return match ($this->priority) {
            self::PRIORITY_HIGH => 'bg-red-500',
            self::PRIORITY_MEDIUM => 'bg-amber-500',
            self::PRIORITY_LOW => 'bg-emerald-500',
            default => 'bg-amber-500',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function getProgressAttribute()
    {
        $total = $this->subtasks()->count();
        if ($total === 0) {
            return $this->status === 'completed' ? 100 : 0;
        }

        $completed = $this->subtasks()->where('is_completed', true)->count();
        return round(($completed / $total) * 100);
    }
}
