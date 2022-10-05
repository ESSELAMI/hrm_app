<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    public function fonctions()
    {
        return $this->hasMany(Fonction::class);
    }
}
