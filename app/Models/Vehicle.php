<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable  = ['licence_plate', 'old_licence_plate', 'status', 'has_gps_tracker', 'identification_number',
        'flag', 'structure_id', 'vehicle_model_id', 'vehicle_type_id', 'fuel_card_id', 'police_number', 'kilometrage',
        'owner_id', 'energy_type_id', 'created_at', 'updated_at', 'engine', 'horsepower'
    ];


    public function accidents()
    {
        return $this->hasMany(Accident::class);
    }

    public function breakdowns()
    {
        return $this->hasMany(Breakdown::class);
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }

    public function insurances()
    {
        return $this->hasMany(Insurance::class)->orderBy('started_at', 'desc');
    }

    public function annualTaxes()
    {
        return $this->hasMany(AnnualTax::class)->orderBy('bought_at', 'desc');
    }

    public function technicalControls()
    {
        return $this->hasMany(TechnicalControl::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class,'vehicle_model_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class,'vehicle_type_id');
    }

    public function energyType()
    {
        return $this->belongsTo(EnergyType::class,'energy_type_id');
    }

     public function fuelCard()
     {
         return $this->hasOne(FuelCard::class);
     }

     public function condition()
     {
         return $this->belongsTo(Condition::class);
     }

     public function affectations()
     {
        return $this->hasMany(Affectation::class)->orderBy('assigned_at', 'desc');
     }

     public function petrolCoupons()
     {
         return $this->hasMany(PetrolCoupon::class);
     }

     public function maintenances()
     {
         return $this->hasMany(Maintenance::class);
     }

     public function reparations()
     {
         return $this->hasMany(Reparation::class);
     }

    public function latestInsurance(){
        return $this->hasOne(Insurance::class)
        ->orderBy('ended_at', 'DESC')->limit(1);
    }

    public function latestAnnualTax(){
        return $this->hasOne(AnnualTax::class)
        ->orderBy('bought_at', 'DESC')->limit(1);
    }

    public function latestTechnicalControl(){
        return $this->hasOne(TechnicalControl::class)
        ->orderBy('ends_at', 'DESC')->limit(1);
    }


}
