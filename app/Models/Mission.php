<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'missions';
    protected $fillable = ['agent_id','started_at','total','ended_at','source_id', 'ended_time','started_time',
     'reason','transportation', 'supported', 'report_scan', 'reference', 'driver_id', 'request_scan', 'status'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function source()
    {
        return $this->belongsTo(Place::class,'source_id');
    }

    public function driver()
    {
        return $this->belongsTo(Agent::class,'driver_id');
    }

    public function destinations()
    {
        return $this->belongsToMany(Place::class)->withTimestamps();
    }

    

}
