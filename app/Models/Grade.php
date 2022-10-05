<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model // TODO : extends Pivot 
{
    protected $table = 'grades';

    public function fonctions()
    {
        return $this->hasMany(Fonction::class);
    }

    public function travelAllowances()
    {
        return $this->hasMany(TravelAllowance::class);
    }
}
