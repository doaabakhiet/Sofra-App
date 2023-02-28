<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealsController extends Controller
{
    public function addMeal(Request $request)
    {
        $product = Product::create($request->all());
        return apiResponse(1, 'تم حفظ البيانات بنجاح', $product);
    }
    public function deleteMeal($id)
    {
        $product = Product::findOrFail($id)->delete();
        return apiResponse(1, 'تم حذف البيانات بنجاح', $product);
    }
    public function editMeal($id)
    {
        $product = Product::find($id);
        if ($product) {
            return apiResponse(1, 'تم بنجاح', $product);
        } else {
            return apiResponse(0, 'لايوجد بيانات', null);
        }
    }
    public function updateMeal(Request $request, $id)
    {
        $product = Product::findOrFail($id)->update($request->all());
        return apiResponse(1, 'تم تعديل البيانات بنجاح', $product);
    }
    public function showRestaurantMeals(Request $request)
    {
        $meals = $request->user()->meals()->paginate(10);
        return apiResponse(1, 'تم بنجاح', $meals);
    }
}
