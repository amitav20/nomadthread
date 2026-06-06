<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'location',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
