<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    //logout
    public function logout(Request $req)
    {
        $req->user()->api_token = '';
        $req->user()->save();
        return apiResponse(1, 'تم تسجيل الخروج بنجاح', $req->user());
    }
    //
    public function editRestaurantData(Request $request)
    {
        if (Auth::guard('api-restaurant')->check()) {
            $validation = validator($request->all(), [
                'restaurant_name' => 'required|max:191',
                'email' => 'required',
                'phone' => 'required',
                'neighborhood_id' => 'required',
                'password' => 'required|confirmed|min:6',
                'minimum_order' => 'required',
                'delivery_fees' => 'required',
                'delivery_phone' => 'required|string',
                'delivery_watsapp_number' => 'required|string',
                'image' => 'required|string',
                'classification_id' => 'required',
            ]);
            if ($validation->fails()) {
                return apiResponse(0, "validation failed", [$validation->errors()]);
            }
            $restaurant = request()->user()->update($request->all());
            $classifications = request()->user()->classifications()->sync($request->classification_id);
            return apiResponse(1, 'تم تعديل البيانات بنجاح', $restaurant);
        }
    }
    //
    
    
    
}
