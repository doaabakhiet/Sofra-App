<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    protected $fillable=['restaurant_id','image','name','description','start_date','end_date'];
    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
    public function getStartDateAttribute($timestamp) {
        return  Carbon::parse($timestamp)->format('l').' '.Carbon::parse($timestamp)->toDateString();
    }
    public function getEndDateAttribute($timestamp) {
        return  Carbon::parse($timestamp)->format('l').' '.Carbon::parse($timestamp)->toDateString();
    }

}