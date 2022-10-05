<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelTracking extends Model
{
    
    protected $table = 'fuel_tracking';

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }   

    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }   


    public function fuelType()
    {
        return $this->hasOne(FuelType::class);
    }   
}
