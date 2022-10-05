<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveDoc extends Model
{
    protected $table = 'leave_docs';
    protected $fillable = ['agent_id','leave_time','leave_date','reason','details','responsable_id','reference',
'return_time'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class);
    }

}
