<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'order', 'is_free'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
