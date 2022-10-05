<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subdirectorate extends Model
{
    protected $table = 'subdirectorates';
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }   
}
