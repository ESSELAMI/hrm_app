<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = "levels";
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }   
}
