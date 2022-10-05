<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    
    protected $table = 'diplomas';

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }    

}
