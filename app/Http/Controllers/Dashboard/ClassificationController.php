<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:classification-list|classification-create|classification-edit|classification-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:classification-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:classification-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:classification-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classifications = Classification::paginate(5);
        return view('Admin.classifications.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.classifications.add_classification');
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
        ]);
        $classifications = Classification::create($request->all());
        flash()->success('Classification Added Successfully')->important();
        return redirect(route('dashboard.classifications.index'));
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
        $classification=Classification::findOrFail($id);
        return view('admin.classifications.edit_classification',compact('classification'));
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
        ]);
        $classification=Classification::find($id);
        $classification->update($request->all());
        flash()->success('Classification Updated Successfully')->important();
        return redirect(route('dashboard.classifications.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classification=Classification::find($id)->delete();
        flash()->success('Classification Deleted Successfully')->important();
        return back();
    }
}
