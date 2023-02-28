<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    protected $fillable=['about_us','title','favicon','commision'];

    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

}