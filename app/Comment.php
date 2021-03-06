<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'content', 'ip'
    ];

    public function user()
    {
        return $this->belongsTo('App\User')->select(['id', 'name', 'avatar']);
    }
}
