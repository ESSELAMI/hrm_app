<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accident extends Model
{

    protected $table = 'accidents';
    protected $fillable = ['vehicle_id','occured_at','location','driver_id',
        'mission_id','deaths','injured','kilometrage','report_url','details'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }


    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }


    public function damages()
    {
        return $this->hasMany(Damage::class);
    }


    public function reparations()
    {
        return $this->hasMany(Reparation::class);
    }



}
