<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    
    protected $table = 'functions';
    protected $fillable = ['name','category_id','section_id'];
   
    public function agents()
    {
        return $this->hasMany(Agent::class);
    } 

    public function category()
    {
        return $this->belongsTo(Category::class);
    }  

    public function section()
    {
        return $this->belongsTo(Section::class);
    }  

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }  

    
    
}
