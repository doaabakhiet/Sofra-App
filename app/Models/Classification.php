<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model 
{

    protected $table = 'classifications';
    protected $fillable=['name'];

    public function restaurants()
    {
        return $this->belongsToMany('App\Models\Restaurant', 'classification_restaurant');
    }

}