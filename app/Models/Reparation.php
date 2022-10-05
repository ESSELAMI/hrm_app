<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reparation extends Model
{
    protected $table = 'reparations';
    protected $fillable = ['mechanic_id','total','started_at','ended_at',
    	'kilometrage','accident_id','breakdown_id','vehicle_id','details'];


    public function reparationDetails()
    {
        return $this->hasMany(Reparation_detail::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function accident()
    {
        return $this->belongsTo(accident::class);
    }

    public function breakdown()
    {
        return $this->belongsTo(Breakdown::class);
    }
}
