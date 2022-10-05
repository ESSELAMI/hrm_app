<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetrolCoupon extends Model
{
    protected $table = 'petrol_coupons';
    protected $fillable = ['vehicle_id','driver_id','assigned_at','kilometrage','coupon_number'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    } 

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    } 
}
