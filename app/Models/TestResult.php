<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = ['user_id', 'test_id', 'score', 'passed', 'answers', 'completed_at'];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
        'passed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
