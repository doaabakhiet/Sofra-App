<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class FeespaidController extends Controller
{
    public function commision(Request $request)
    {
        // total sales : 10000
        $total_restaurant_sales = $request->user()->orders()->sum('total_price');
        // total commissions : 1000 (10%)
        $appfees = $request->user()->orders()->sum('app_commission');
        // total paid : 600
        $paid = $request->user()->commission()->sum('amount');
        // total remaining : 400
        $remaining_fees = $appfees - $paid;
        $setting = Setting::first();

        
        $total_restaurant_sales = $request->user()->orders()->sum('total_price');
        // $appfees = $total_restaurant_sales / $setting->commision;
        $appfees = $request->user()->orders()->sum('app_commission');
        // $request->user()->commission()->updateOrCreate(
        //     ['restaurant_id' => $request->user()->id],
        //     [
        //         'restaurant_sales' => $total_restaurant_sales,
        //         'app_fees' => $appfees,
        //         'remaining_fees'=>$appfees,
        //     ]
        // );

        return apiResponse(1, 'تم بنجاح', [
            'commisions' => $request->user()->commission()->first(),
            'total_restaurant_sales'=>$total_restaurant_sales,
            'appfees'=>$appfees,
            'setting' => $setting
        ]);
    }
    public function payFees(Request $request)
    {
        $validation = validator($request->all(), [
            'payment_method' => 'required',
            'price' => 'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", [$validation->errors()]);
        }

        $restaurant_commision = $request->user()->commission()->first();
        // if ($request->user()->commission()->exists()) {
            if ($request->price <= $restaurant_commision->remaining_fees) {
                $fees_paid = $restaurant_commision->fees_paid + $request->price;
                $remaining_fees = $restaurant_commision->app_fees - $fees_paid;
            } else {
                return "المبلغ الذى ادخلته اكبر من المتبقى";
            }
            $commision = $request->user()->commission()->update(
                [
                    'fees_paid' => $fees_paid,
                    'remaining_fees' => $remaining_fees,
                    'payment_method' => $request->payment_method,
                    'payment_date' => date('Y-m-d'),
                    'notes' => $request->notes,
                    'status' => $restaurant_commision->app_fees == $restaurant_commision->fees_paid ? '1' : '0'
                ]
            );
        // }else{

        // }
        return apiResponse(1, 'تم بنجاح', $commision);
    }
}
