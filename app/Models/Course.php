<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'level', 
        'type', 
        'price', 
        'tutor_id', 
        'is_published',
        'thumbnail',
        'preview_video',
        'category',
        'tags',
        'duration_weeks',
        'estimated_hours',
        'learning_outcomes',
        'prerequisites',
        'instructor_bio',
        'original_price',
        'discount_percentage',
        'has_payment_plan',
        'is_featured',
        'has_certificate',
        'certificate_template',
        'max_students',
        'language',
        'difficulty'
    ];

    protected $casts = [
        'tags' => 'array',
        'learning_outcomes' => 'array',
        'prerequisites' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'has_certificate' => 'boolean',
        'has_payment_plan' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    // Get discounted price
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percentage > 0 && $this->original_price) {
            return $this->original_price - ($this->original_price * $this->discount_percentage / 100);
        }
        return $this->price;
    }

    // Get final price (considers discount)
    public function getFinalPriceAttribute()
    {
        return $this->discount_percentage > 0 ? $this->discounted_price : $this->price;
    }


    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function tests()
    {
        return $this->hasMany(Test::class)->orderBy('order');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Check if a user is enrolled in this course
    public function isEnrolledBy($user)
    {
        if (!$user) return false;
        return $this->students()->where('user_id', $user->id)->exists();
    }

    // Get enrollment for specific user
    public function getEnrollmentFor($user)
    {
        if (!$user) return null;
        return $this->enrollments()->where('user_id', $user->id)->first();
    }

    // Calculate progress percentage for a user
    public function getProgressFor($user)
    {
        $enrollment = $this->getEnrollmentFor($user);
        if (!$enrollment) return 0;

        $totalLessons = $this->lessons()->count();
        $totalTests = $this->tests()->count();
        $totalItems = $totalLessons + $totalTests;

        if ($totalItems === 0) return 0;

        $progress = $enrollment->progress ?? [];
        $completedLessons = $progress['completed_lessons'] ?? [];
        $completedTests = $progress['completed_tests'] ?? [];

        $completedItems = count($completedLessons) + count($completedTests);

        return round(($completedItems / $totalItems) * 100);
    }

    // Scope for published courses
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
