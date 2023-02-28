<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{
    protected $table = 'orders';
    protected $fillable=['client_id','restaurant_id','app_commission','price','total_price','delivery_fees','status','payment_method','notes','address','phone'];
    public function getCreatedAtAttribute($timestamp) {
        return Carbon::parse($timestamp)->format('l').' '.Carbon::parse($timestamp)->toDateString();
    }

    public function changeOrderStatus($status)
    {
        $this->update([
            'status' => $status
        ]);
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_product')->withPivot('quantity','order_description','price');
    }

}