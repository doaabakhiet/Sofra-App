<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $offers = request()->user()->offers()->latest()->paginate(10);
        return apiResponse(1, 'تم بنجاح', $offers);
    }
    public function createOffer(Request $request)
    { 
        if (Auth::guard('api-restaurant')->check()) {
            $validation = validator($request->all(), [
                'name' => 'required|max:191',
                'description' => 'required',
                'image' => 'required|string',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            if ($validation->fails()) {
                return apiResponse(0, "validation failed", [$validation->errors()]);
            }
            $offer = request()->user()->offers()->create($request->all());

            $orders= request()->user()->orders()->get();
            foreach($orders as $order)
            {
                $clients= $order->client->distinct()->get();
            }
            foreach($clients as $client){
                $notifications = $client->notifications()->create([
                    'title' => request()->user()->restaurant_name . 'يوجد عرض جديد من',
                    'content' =>  $offer->name.' # يوجد عرض',
                ]);
                sendNotification($notifications,$offer);
            }
            
            return apiResponse(1, 'تم حفظ البيانات بنجاح', $offer);
        }
    }
    public function deleteOffer($id)
    {
        $offer = request()->user()->offers()->find($id)->delete();
        return apiResponse(1, 'تم حذف البيانات بنجاح', $offer);
    }
    public function editOffer($id)
    {
        if (Offer::where('id', $id)->exists()) {
            $offer = request()->user()->offers()->findOrFail($id);
            return apiResponse(1, '', $offer);
        } else {
            return apiResponse(0, 'لايوجد بيانات', null);
        }
    }
    public function updateOffer(Request $request, $id)
    {
        $validation = validator($request->all(), [
            'name' => 'required|max:191',
            'description' => 'required',
            'image' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", [$validation->errors()]);
        }
        $offer = request()->user()->offers()->findOrFail($id)->update($request->all());
        return apiResponse(1, 'تم تعديل البيانات بنجاح', $offer);
    }
}
