<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesPaid extends Model 
{

    protected $table = 'fees_paid';
    protected $fillable=['restaurant_id','restaurant_sales','app_fees','fees_paid','remaining_fees','payment_method','notes','payment_date','status'];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

}