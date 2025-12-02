<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomSession extends Model
{
    protected $fillable = [
        'classroom_id',
        'started_at',
        'ended_at',
        'duration_minutes',
        'recording_url',
        'participants_count',
        'analytics',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'analytics' => 'array',
    ];

    // Relationships
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Helper methods
    public function isActive()
    {
        return $this->started_at && !$this->ended_at;
    }

    public function getDuration()
    {
        if ($this->duration_minutes) {
            return $this->duration_minutes;
        }

        if ($this->started_at && $this->ended_at) {
            return $this->ended_at->diffInMinutes($this->started_at);
        }

        if ($this->started_at) {
            return now()->diffInMinutes($this->started_at);
        }

        return 0;
    }

    public function getFormattedDuration()
    {
        $minutes = $this->getDuration();
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return $mins > 0 ? "{$hours}h {$mins}m" : "{$hours}h";
        }

        return "{$mins}m";
    }
}
