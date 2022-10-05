<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructureType extends Model
{
    protected $table = 'structure_types';

    public function structures()
    {
        return $this->hasMany(Structure::class);
    }
}
