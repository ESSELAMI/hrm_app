<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'communes';

    public function commune_sources()
    {
        return $this->hasMany(CommuneDistance::class);
    }

    public function commune_destinations()
    {
        return $this->hasMany(CommuneDistance::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function missions()
    {
        return $this->belongsToMany(Mission::class)->withTimestamps();
    }
}
