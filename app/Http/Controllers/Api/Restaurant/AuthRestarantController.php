<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthRestarantController extends Controller
{
    public function createRestaurant(Request $req)
    {
        $validation = validator($req->all(), [
            'restaurant_name' => 'required|max:191',
            'email' => 'required|unique:restaurants',
            'phone' => 'required|unique:restaurants|min:8',
            'neighborhood_id' => 'required',
            'password' => 'required|confirmed|min:6',
            'minimum_order'=>'required',
            'delivery_fees'=>'required',
            'delivery_phone'=>'required|string',
            'delivery_watsapp_number'=>'required|string',
            'image'=>'required|string',
            'classification_id'=>'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed",[ $validation->errors()]);
        }
        // $req->merge(['password' => bcrypt($req->password)]);
        $restaurant =Restaurant::create($req->all());
        $restaurant->api_token = Str::random(60);
        $restaurant->save();
        $classifications=$restaurant->classifications()->attach($req->classification_id);
        return apiResponse(1, "Data Added Successfully", [
            'api_tokent' => $restaurant->api_token,
            'Restaurant' => $restaurant
        ]);
    }

    public function loginRestaurant(Request $req)
    {
        $validation = validator($req->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", $validation->errors());
        }
        $restaurant = Restaurant::where('email', $req->email)->first();
        if ($restaurant) {
            if (Hash::check($req->password, $restaurant->password)) {
                $restaurant->api_token = Str::random(60);
                $restaurant->save();  
                return apiResponse(0, "You are Logged In", [
                    'api_token' => $restaurant->api_token,
                    'Restaurant' => $restaurant
                ]);
            } else {
                return apiResponse(0, "You are Not Logged In");
            }
        } else {
            return apiResponse(0, "Data Is Not Right");
        }
    }

    public function forgetPassword(Request $req)
    {
        $validation = validator($req->all(), [
            'email' => 'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", $validation->errors());
        }
        $user = Restaurant::where('email', $req->email)->first();
        if ($user) {
            $code = Str::rand(1111, 9999);
            $user->pin_code = $code;
            $user->save();
            if ($user->pin_code == $code) {

                //     //smsMisr

                Mail::to($user->email)
                    ->bcc("doaabakhiet11@gmail.com")
                    ->send(new ResetPassword($user));
                return apiResponse(1, "برجاء فحص بريدك الالكترونى", [
                    "pincode_for_test" => $code,
                    // 'mail_failures'=>Mail::failures(),
                    'email' => $user->email
                ]);
            } else {
                return apiResponse(0, "حدث خطأ برجاء حاول مرة اخرى", $user);
            }
        } else {
            return apiResponse(0, "لا يوجد اى حساب مرتبط بهذا الهاتف");
        }
    }

    public function newPassword(Request $req)
    {
        $validation = validator($req->all(), [
            'pin_code' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", $validation->errors());
        }
        $restaurant = Restaurant::where('pin_code', $req->pin_code)->first();
        $update = $restaurant->update([
            'password' => $req->restaurant,
        ]);
        if ($update) {
            return apiResponse(1, "تم تغيير كلمة المرور بنجاح", $restaurant);
        } else {
            return apiResponse(0, "حدث خطأ برجاء حاول مرة اخرى", $restaurant);
        }
    }
    
}
