<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:setting-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings=Setting::first();
        return view('Admin.settings.index',compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'about_us' => 'required',
            'title'=>'required',
            //'favicon'=>'',
            'commision'=>'required',
            'account_name'=>'required',
            'account_number'=>'required'
        ]);
        // dd($request->all());
        $settings = Setting::find($id);
        if ($request->HasFile('favicon')) {
            $path='images/'.$settings->photo;
            if(File::exists($path)){
                File::delete($path);
            }
            $image= $request->file('favicon');
            // $ext = $image->getClientOriginalExtension();
            $filename = 'favicon.ico';
            $image->move("images/", $filename);
            $settings->favicon=$filename;
            $settings->save();
        }
        $settings = Setting::find($id)->update($request->except('favicon'));
        if($request->account_name){
            // $accounts=Setting::find($id)->accounts()->count();
            $i=1;
            foreach(Setting::find($id)->accounts()->get() as $account){
                $account->update([
                    'account_name'=>$request->account_name[$i],
                    'account_number'=>$request->account_number[$i],
                ]);
                $i++;
            }
        }
        flash()->success('Setting Updated Successfully')->important();
        return redirect(route('dashboard.setting.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $setting=Setting::find($id)->delete();
    }
}
