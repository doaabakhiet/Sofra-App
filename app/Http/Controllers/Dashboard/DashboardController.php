<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin');
    }
    public function managePassword()
    {
        return view('Admin.manage_password');
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'confirm_password'=>'required|same:password',
            'old_password' => 'required',
          ]);
        $user=User::findOrFail(Auth::user()->id);
        if(Hash::check($request->old_password, $user->password)){
            $user->password=$request->password;
            $user->save();
            flash()->success('تم تغيير كلمة المرور بنجاح');
        }
        else{
            flash()->success('كلمة المرور غير صحيحة');
        }
        return redirect()->back();        
    }
    // public function editSetting(Request $request, $id)
    // {
    //     $setting = Setting::findOrFail($id);
    //     return view('admin.settings.index', compact('setting'));
    // }


}
