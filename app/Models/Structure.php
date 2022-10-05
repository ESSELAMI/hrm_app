<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $table = 'structures';

    public function mechanics()
    {
        return $this->hasMany(Mechanic::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function structureType()
    {
        return $this->belongsTo(StructureType::class);
    }

    public function vehicleAffectations()
    {
        return $this->hasMany(vehicleAffectation::class);
    }

    public function insurranceCompanies()
    {
        return $this->hasMany(InsurranceCompany::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

}
