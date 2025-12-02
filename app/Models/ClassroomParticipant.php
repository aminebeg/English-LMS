<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomParticipant extends Model
{
    protected $fillable = [
        'classroom_id',
        'user_id',
        'role',
        'joined_at',
        'left_at',
        'is_active',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function join()
    {
        $this->update([
            'is_active' => true,
            'joined_at' => now(),
            'left_at' => null,
        ]);
    }

    public function leave()
    {
        $this->update([
            'is_active' => false,
            'left_at' => now(),
        ]);
    }

    public function isActive()
    {
        return $this->is_active;
    }
}
