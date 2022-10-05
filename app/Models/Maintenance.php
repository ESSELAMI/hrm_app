<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{

    protected $table = 'maintenances';
    protected $fillable = ['mechanic_id','cost','started_at','ended_at',
    	'kilometrage','vehicle_id','details'];

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function maintenanceDetails()
    {
        return $this->hasMany(MaintenanceDetail::class);
    }
}
