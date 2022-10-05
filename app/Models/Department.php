<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    
    protected $table = 'departments';

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }  

    public function strcuture()
    {
        return $this->belongsTo(Structure::class);
    }  
}
