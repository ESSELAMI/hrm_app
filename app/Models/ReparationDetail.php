<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReparationDetail extends Model
{
    protected $table = 'reparation_details';

    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }
}
