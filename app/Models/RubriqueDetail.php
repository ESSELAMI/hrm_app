<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubriqueDetail extends Model
{
    use HasFactory;

    protected $table = 'rubriques_values';

    protected $fillable = ['day', 'value', 'rubrique_id'];

    public function rubrique()
    {
        return $this->belongsTo(Rubrique::class);
    }
}
