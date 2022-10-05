<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicle_models';

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
