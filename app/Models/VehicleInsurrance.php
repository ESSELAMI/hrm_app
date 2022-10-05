<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleInsurrance extends Model
{
    protected $table = 'vehicle_insurrances';

    public function insurranceCompany()
    {
        return $this->belongsTo(InsurranceCompany::class);
    }

    public function vehicle()
    {
        return $this->belognsTo(Vehicle::class);
    }

    public function structure()
    {
        return $this->belognsTo(Structure::class);
    }
}
