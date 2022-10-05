<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommuneDistance extends Model
{
    protected $table = 'distances';
    protected $fillable = ['distance', 'source_id', 'destination_id'];

    public function source()
    {
        return $this->belongsTo(Place::class,'source_id');
    }

    public function destination()
    {
        return $this->belongsTo(Place::class,'destination_id');
    }

}
