<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
    
    protected $table = 'breakdowns';

    public function Vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    } 
     
    public function reparations()
    {
        return $this->hasMany(Reparation::class);
    } 
}
