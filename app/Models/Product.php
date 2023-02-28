<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    protected $fillable=['name','description','price','offer_price','has_offer','order_preparation_time','restaurant_id','image'];
    
    
    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_product')->withPivot('quantity','order_description','price');
    }

}