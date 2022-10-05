<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';

    protected $fillable = [ 'firstname','lastname','firstname_ar','lastname_ar', 'phone_number', 'address','address_ar', 'agent_number',
        'account_number', 'function_id', 'recrutment_date', 'birthdate', 'birthplace', 'sexe',
        'job_id', 'department_id', 'subdirectorate_id', 'diploma_id', 'diploma_date', 'level_id','vehicle_licence_number'
    ];

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }  

    public function leave_docs()
    {
        return $this->hasMany(LeaveDoc::class);
    }  
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }  

    public function fonction()
    {
        return $this->belongsTo(Fonction::class,'function_id');
    }  

    public function diploma()
    {
        return $this->belongsTo(Diploma::class,'diploma_id');
    }  

    public function subdirectorate()
    {
        return $this->belongsTo(Subdirectorate::class,'subdirectorate_id');
    }  

    public function job()
    {
        return $this->belongsTo(Job::class);
    }  

    public function level()
    {
        return $this->belongsTo(Level::class,'level_id');
    }  

    public function latestConfirmedLevel(){
        return $this->hasOne(ConfirmedLevel::class)
        ->orderBy('next_at', 'DESC')->limit(1);
    }

    public function confirmedLevels(){
        return $this->hasMany(ConfirmedLevel::class);
    }

    
}
