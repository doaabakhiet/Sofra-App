<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:restaurant-list|restaurant-create|restaurant-edit|restaurant-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:restaurant-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:restaurant-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:restaurant-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restaurants = Restaurant::where(function ($query) use ($request) {
            if ($request->search) {
                $query->WhereHas('neighborhoods', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                })->orWhere('restaurant_name', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('delivery_watsapp_number', 'like', '%' . request('search') . '%')
                    ->orWhere('delivery_phone', 'like', '%' . request('search') . '%');
            }
        })->paginate(5);
        return view('Admin.restaurants.index', compact('restaurants'));
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
        $restaurant = Restaurant::find($id);
        return view('Admin.restaurants.show_restaurant', compact('restaurant'));
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
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();
        flash()->success('Restaurant Deleted Successfully');
        return back();
    }
    public function toggleActive(Request $request)
    {
        $id = $request->get('id');
        $restaurant = Restaurant::findOrFail($id);
        if ($restaurant->status == '1') {
            $restaurant->status = '0';
        } else {
            $restaurant->status = '1';
        }
        $restaurant->save();
        return response()->json(['active' => $restaurant->status]);
    }
}
