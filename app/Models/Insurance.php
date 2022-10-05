<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $table = 'vehicle_insurrances';

    protected $fillable = ['vehicle_id','structure_id','insurrance_company_id','started_at','ended_at',
    	        'cost','police_number'];

    public function insurranceCompany()
    {
        return $this->belongsTo(InsurranceCompany::class,'insurrance_company_id');
    }

    public function vehicle()
    {
        return $this->belognsTo(Vehicle::class,'vehicle_id');
    }

    public function structure()
    {
        return $this->belognsTo(Structure::class,'structure_id');
    }
}
