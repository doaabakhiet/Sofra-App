<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //logout
    public function logout(Request $request)
    {
        $request->user()->api_token = '';
        $request->user()->save();
        return apiResponse(1, 'تم تسجيل الخروج بنجاح', $request->user());
    }
    //
    public function editData(Request $request)
    {
        $validation = validator($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required',
            'phone'=>'required|string',
            'neighborhood_id'=>'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed",[ $validation->errors()]);
        }
        $client=request()->user()->Update($request->all());
        return apiResponse(1, 'تم بنجاح', $client);
    }
    //
    public function restaurants(Request $request)
    {
        $restaurants = Restaurant::with('neighborhoods')->where(function ($query) use ($request) {
            if ($request->city_id) {
                $query->WhereHas('neighborhoods', function ($query) use ($request) {
                    $query->WhereHas('cities', function ($query) use ($request) {
                        $query->where('cities.id', request('city_id'));
                    });
                });
            }
            if ($request->restaurant_name) {
                $query->where('restaurant_name', 'like', '%' . request('restaurant_name') . '%');
            }
        })->paginate(5);
        return apiResponse(1, 'تم بنجاح', $restaurants);
    }
    //
    public function showRestaurantsMeals($id)
    {
        $meals=Restaurant::findOrFail($id)->products()->paginate(15);
        return apiResponse(1, 'تم بنجاح', $meals);
    }
    public function showMealDetails($meal_id)
    {
        $meal=Product::findOrFail($meal_id);
        return apiResponse(1, 'تم بنجاح', $meal);
    }
    public function showReviews($restaurant_id)
    {
        $reviews=Restaurant::findOrFail($restaurant_id)->clients()->paginate(15);
        return apiResponse(1, 'تم بنجاح', $reviews);
    }
    public function createReview(Request $request,$restaurant_id)
    {
        $validation = validator($request->all(), [
            'coment' => 'required',
            'emoji'=>'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed",[ $validation->errors()]);
        }
        $review=request()->user()->restaurants()->attach($restaurant_id,['coment' => $request->coment,'emoji'=>$request->emoji]);
        return apiResponse(1, 'تم بنجاح', $review);
    }
    public function offers()
    {
        $offers=Offer::where('end_date','<=',date('d-m-y'))->latest()->get();
        return apiResponse(1, 'تم بنجاح', $offers);
    }
}
