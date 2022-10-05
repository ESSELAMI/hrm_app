<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    
    protected $table = 'jobs';
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }    
}
