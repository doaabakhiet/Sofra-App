<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
            'type' => 'required|in:android,IOS'
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return apiResponse(0, "Failed", $data);
        }
        Token::where('token', $request->token)->delete();
            request()->user()->tokens()->create([
                'token'=>$request->token,
                'type'=>$request->type,
                'user_type'=>Auth::guard('api')->check()?'client':'restaurant'
            ]);
        return apiResponse(1, "تم التسجيل بنجاح");
    }
    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return apiResponse(0, "Failed", $data);
        }
        Token::where('token', $request->token)->delete();
        return apiResponse(1, "تم الحذف بنجاح");
    }
    public function notificationList(Request $request)
    {
        $data = $request->user()->notifications()->latest()->paginate(10);
        return apiResponse(1, "success", $data);
    }
    public function notificationCount(Request $request)
    {
        $data = $request->user()->notifications()->where('isread','!=','1')->count();
        return $data;
    }
    public function notification($id, Request $request)
    {
        $notification=request()->user()->notifications()->find($id);
        if($notification){
            $notification->isread = '1';
            $notification->update();
        }
        return apiResponse(1, "success", $notification);
    }
}
