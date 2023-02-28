<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model 
{

    protected $table = 'tokens';
    protected $fillable=['user_type','user_id','token','type'];
    public function user()
    {
        return $this->morphTo();
    }

}