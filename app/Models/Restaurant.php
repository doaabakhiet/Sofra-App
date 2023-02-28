<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Restaurant extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'restaurants';
    protected $fillable = ['restaurant_name','email','phone','neighborhood_id','password','pin_code','minimum_order','delivery_fees','delivery_phone','delivery_watsapp_number','image','status'];
    protected $hidden = [
        'password','api_token'
    ];
    protected $appends = array('isOpen');
    public function getIsOpenAttribute()
    {
        if($this->status=='1'){
            return 'Open';
        }else{
            return "close";
        }
    }
    public function setPasswordAttribute($value){
        $this->attributes['password']=bcrypt($value);
    }

    public function neighborhoods()
    {
        return $this->belongsTo('App\Models\Neighborhood', 'neighborhood_id');
    }

    public function classifications()
    {
        return $this->belongsToMany('App\Models\Classification', 'classification_restaurant');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client', 'reviews')->withPivot('coment','emoji');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function commission()
    {
        return $this->hasMany('App\Models\FeesPaid');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'user');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'user');
    }

}