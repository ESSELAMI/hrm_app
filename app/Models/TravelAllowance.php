<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelAllowance extends Model
{
    protected $table = 'travel_allowances';

    public function grade()
    {
        return $this->belognsTo(Grade::class);
    }

    
}
