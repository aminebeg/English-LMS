<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    protected $fillable = [
        'classroom_id',
        'sender_id',
        'receiver_id',
        'type',
        'payload',
        'is_processed'
    ];
    //
}
