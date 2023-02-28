<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Client extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'clients';
    protected $fillable = ['name','email','phone','neighborhood_id','password','pin_code'];
    protected $hidden = [
        'password','api_token'
    ];
    public function setPasswordAttribute($value){
        $this->attributes['password']=bcrypt($value);
    }
    public function neighborhoods()
    {
        return $this->belongsTo('App\Models\Neighborhood', 'neighborhood_id');
    }

    public function restaurants()
    {
        return $this->belongsToMany('App\Models\Restaurant', 'reviews')->withPivot('coment','emoji');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
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