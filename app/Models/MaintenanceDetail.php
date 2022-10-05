<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
{
    
    protected $table = 'maintenance_details';
    
    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }  

    public function maintenanceType()
    {
        return $this->hasOne(MaintenanceType::class);
    }  
}
