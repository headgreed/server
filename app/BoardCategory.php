<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardCategory extends Model
{
    public function boards()
    {
        return $this->hasMany(\App\Board::class);
    }
}
