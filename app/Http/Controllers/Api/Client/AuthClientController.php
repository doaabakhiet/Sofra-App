<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthClientController extends Controller
{
    public function createClient(Request $req)
    {
        $validation = validator($req->all(), [
            'name' => 'required|max:191',
            'email' => 'required|unique:clients',
            'phone' => 'required|unique:clients|min:8',
            'neighborhood_id' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", [$validation->errors()]);
        }
        $client = Client::create($req->all());
        $client->api_token = Str::random(60);
        $client->save();
        return apiResponse(1, "Data Added Successfully", [
            'api_tokent' => $client->api_token,
            'client' => $client
        ]);
    }
    public function loginClient(Request $req)
    {
        $validation = validator($req->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", $validation->errors());
        }
        $client = Client::where('email', $req->email)->first();
        if ($client) {
            if (Hash::check($req->password, $client->password)) {
                $client->api_token = Str::random(60);
                $client->save();
                return apiResponse(0, "You are Logged In", [
                    'api_token' => $client->api_token,
                    'client' => $client
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
        $user = Client::where('email', $req->email)->first();
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
        $client = Client::where('pin_code', $req->pin_code)->first();
        $update = $client->update([
            'password' => $req->password,
        ]);
        if ($update) {
            return apiResponse(1, "تم تغيير كلمة المرور بنجاح", $client);
        } else {
            return apiResponse(0, "حدث خطأ برجاء حاول مرة اخرى", $client);
        }
    }
}
