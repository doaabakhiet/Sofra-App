<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:client-list|client-create|client-edit|client-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:client-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::where(function($query) use($request){
            if($request->search){
              $query->WhereHas('neighborhoods', function ($query) use ($request) {
                $query->where('name', 'like', '%' . request('search') . '%');
              })->orWhere('name', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('phone', 'like', '%' . request('search') . '%');
            }
          })->paginate(5);
        return view('Admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $neighborhoods=Neighborhood::all();
        // return view('Admin.clients.add_client',compact('neighborhoods'));
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
        //     'name' => 'required',
        //     'email'=>'required|unique:clients,email,$this->id,id',
        //     'phone'=>'required|unique:clients,phone,$this->id,id',
        //     'neighborhood_id'=>'required|exists:neighborhoods,id',
        // ]);
        // $client = Client::create($request->all());
        // flash()->success('Client Added Successfully')->important();
        // return redirect(route('dashboard.clients.index'));
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
        $client=Client::findOrFail($id);
        $client->delete();
        flash()->success('Client Deleted Successfully');
        return back();
    }
    public function toggleActive(Request $request){
        $id=$request->get('id');
        $client=Client::findOrFail($id);
        if($client->isactive=='1'){
            $client->isactive='0';
        }else{
            $client->isactive='1';
        }
        $client->save();
        return response()->json(['active'=>$client->isactive]);

    }
}
