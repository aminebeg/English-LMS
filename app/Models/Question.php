<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['test_id', 'content', 'type', 'options', 'correct_answer', 'order'];

    protected $casts = [
        'options' => 'array',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
