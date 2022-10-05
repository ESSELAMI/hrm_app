<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmedLevel extends Model
{
    protected $table = 'confirmed_levels';
    protected $fillable = ['user_id','qr_code','agent_id','level_id','confirmed_at','next_at','state','details'];
    

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class,'agent_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class,'level_id');
    }

}
