<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table = 'vehicle_types';

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
