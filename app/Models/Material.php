<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['lesson_id', 'title', 'type', 'content', 'file_path', 'file_name', 'file_size', 'mime_type'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
