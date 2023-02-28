<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:account-list|account-create|account-edit|account-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:account-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:account-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:account-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'account_name'=>'required',
        //     'account_number'=>'required'
        // ]);
        $setting=Setting::first();
        $setting->accounts()->create([
            'account_name'=>$request->get('account_name'),
            'account_number'=>$request->get('account_number'),
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account=Account::find($id)->delete();
    }
}
