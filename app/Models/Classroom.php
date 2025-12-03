<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Classroom extends Model
{
    protected $fillable = [
        'teacher_id',
        'course_id',
        'title',
        'description',
        'slug',
        'join_code',
        'max_participants',
        'is_active',
        'is_public',
        'price',
        'is_featured',
        'is_paid_access',
        'scheduled_at',
        'duration_minutes',
        'status',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'is_paid_access' => 'boolean',
        'price' => 'decimal:2',
        'scheduled_at' => 'datetime',
        'settings' => 'array',
    ];

    // Boot method to auto-generate slug and join code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($classroom) {
            if (empty($classroom->slug)) {
                $classroom->slug = Str::slug($classroom->title) . '-' . Str::random(6);
            }
            if (empty($classroom->join_code)) {
                $classroom->join_code = strtoupper(Str::random(8));
            }
        });
    }

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function participants()
    {
        return $this->hasMany(ClassroomParticipant::class);
    }

    public function sessions()
    {
        return $this->hasMany(ClassroomSession::class);
    }

    public function messages()
    {
        return $this->hasMany(ClassroomMessage::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeStandalone($query)
    {
        return $query->whereNull('course_id');
    }

    public function scopeFree($query)
    {
        return $query->where('price', 0);
    }

    public function scopePaid($query)
    {
        return $query->where('price', '>', 0);
    }

    // Helper methods
    public function isTeacher($user)
    {
        return $this->teacher_id === $user->id;
    }

    public function hasParticipant($user)
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    public function activeParticipants()
    {
        return $this->participants()->where('is_active', true)->with('user')->get();
    }

    public function participantsCount()
    {
        return $this->participants()->count();
    }

    public function canJoin()
    {
        return $this->is_active && 
               $this->status !== 'ended' && 
               $this->participantsCount() < $this->max_participants;
    }

    public function isFree()
    {
        return $this->price == 0;
    }

    public function isPaid()
    {
        return $this->price > 0;
    }

    public function isStandalone()
    {
        return $this->course_id === null;
    }

    public function hasAccess($user)
    {
        // Free classrooms are accessible to everyone
        if ($this->isFree()) {
            return true;
        }

        // Check if user has paid for access
        return $this->participants()
            ->where('user_id', $user->id)
            ->where('is_paid_access', true)
            ->exists();
    }

    public function startSession()
    {
        $this->update(['status' => 'live']);
        
        return $this->sessions()->create([
            'started_at' => now(),
        ]);
    }

    public function endSession()
    {
        $this->update(['status' => 'ended']);
        
        $session = $this->sessions()->latest()->first();
        if ($session && !$session->ended_at) {
            $session->update([
                'ended_at' => now(),
                'duration_minutes' => now()->diffInMinutes($session->started_at),
                'participants_count' => $this->participantsCount(),
            ]);
        }
        
        // Set all participants as inactive
        $this->participants()->update(['is_active' => false, 'left_at' => now()]);
        
        return $session;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
