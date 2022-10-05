<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    protected $table='vehicle_affectations';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'structure_id', 'owner_id', 'vehicle_id','assigned_at','kilometrage','status','decision_file',
        'decision_number'

    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }

    public function structure()
    {
        return $this->belognsTo(Structure::class,'structure_id');
    }
}
