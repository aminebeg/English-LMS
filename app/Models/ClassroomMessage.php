<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomMessage extends Model
{
    protected $fillable = [
        'classroom_id',
        'user_id',
        'message',
        'type',
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
    public function isSystemMessage()
    {
        return $this->type === 'system';
    }

    public function isAnnouncement()
    {
        return $this->type === 'announcement';
    }
}
