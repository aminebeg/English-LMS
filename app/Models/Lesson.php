<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'course_section_id',
        'title', 
        'content',
        'order',
        'is_preview',
        'video_url',
        'summary',
        'objectives',
        'notes',
        'duration_minutes',
        'difficulty',
        'key_points',
        'vocabulary',
        'exercises',
        'resources',
        'downloads',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'is_published' => 'boolean',
        'objectives' => 'array',
        'key_points' => 'array',
        'vocabulary' => 'array',
        'exercises' => 'array',
        'resources' => 'array',
        'downloads' => 'array',
        'published_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    // Get formatted duration
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_minutes) return null;
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return $minutes > 0 ? "{$hours}h {$minutes}m" : "{$hours}h";
        }
        
        return "{$minutes}m";
    }
}
