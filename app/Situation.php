<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Situation extends Model
{
    protected $fillable = [
        'title', 'description', 'status', 'file', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
