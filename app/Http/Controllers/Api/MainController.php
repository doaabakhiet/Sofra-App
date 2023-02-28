<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Classification;
use App\Models\ContactUs;
use App\Models\Neighborhood;
use App\Models\Setting;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //getCities
    public function cities()
    {
        $data = City::all();
        return apiResponse(1, "success", $data);
    }
    //getCities
    public function neighborhoods()
    {
        $data = Neighborhood::all();
        return apiResponse(1, "success", $data);
    }
    public function classifications()
    {
        $data = Classification::all();
        return apiResponse(1, "success", $data);
    }
    public function settings()
    {
        $data = Setting::all();
        return apiResponse(1, "success", $data);
    }
    //contact us
    public function contactUs(Request $req)
    {
        $validation = validator($req->all(), [
            'fullname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
            'type' => 'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", $validation->errors());
        }
        $data = ContactUs::create([
            'fullname' => $req->fullname,
            'email' => $req->email,
            'phone' => $req->phone,
            'message' => $req->message,
            'type' => $req->type
        ]);
        return apiResponse(1, "success", $data);
    }
}
