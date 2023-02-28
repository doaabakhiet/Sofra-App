<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    protected $fillable=['user_type','user_id','title','content'];
    public function user()
    {
        return $this->morphTo();
    }

}