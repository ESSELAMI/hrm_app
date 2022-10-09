<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrique extends Model
{
    use HasFactory;

    protected $table = 'rubriques';
    protected $fillable = ['name', 'service_id'];

    public function rubriques()
    {
        return $this->belongsTo(Service::class);
    }
    public function values()
    {
        return $this->hasMany(RubriqueDetail::class);
    }
}
