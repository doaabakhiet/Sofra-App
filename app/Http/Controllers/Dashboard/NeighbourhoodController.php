<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class NeighbourhoodController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:neighborhood-list|neighborhood-create|neighborhood-edit|neighborhood-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:neighborhood-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:neighborhood-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:neighborhood-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $neighbourhoods = Neighborhood::paginate(5);
        return view('Admin.neighbourhoods.index', compact('neighbourhoods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.neighbourhoods.add_neighbourhood');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'city_id'=>'required'
        ]);
        $neighborhood = Neighborhood::create($request->all());
        flash()->success('Neighborhood Added Successfully')->important();
        return redirect(route('dashboard.neighbourhoods.index'));
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
        $neighborhood=Neighborhood::findOrFail($id);
        return view('admin.neighbourhoods.edit_neighbourhood',compact('neighborhood'));
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
            'name' => 'required',
            'city_id'=>'required'
        ]);

        $neighbourhood=Neighborhood::find($id);
        $neighbourhood->update($request->all());
        flash()->success('Neighborhood Updated Successfully')->important();
        return redirect(route('dashboard.neighbourhoods.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $neighbourhood=Neighborhood::find($id)->delete();
        flash()->success('Neighborhood Deleted Successfully')->important();
        return back();
    }
}
