<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'profession',
        'phone_number',
        'about',
        'facebook_url',
        'linkedin_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
