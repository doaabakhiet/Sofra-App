<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\FeesPaid;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $validation = validator($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'payment_method' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required',
            'items.*.price' => 'required',
        ]);
        if ($validation->fails()) {
            return apiResponse(0, "validation failed", [$validation->errors()]);
        }
        $setting = Setting::first();
        $restaurant = Restaurant::find($request->restaurant_id);
        if ($restaurant->status == '0') {
            return apiResponse(1, 'المطعم مغلق الان');
        }
        $order = $request->user()->orders()->create($request->all());
        
        //store products
        $price=0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $price +=($item['price'] * $item['quantity']);
            $product->orders()->attach($order->id, ['quantity' => $item['quantity'], 'price' => $item['price'], 'order_description' => $item['order_description']]);
        }
        if($price>=$restaurant->minimum_order){
            $order->price = $price;
            // $order->total_price = $price + $order->delivery_fees + ($order->app_commission*$price/100);
            $order->total_price = $price + $restaurant->delivery_fees;
            $order->app_commission = $setting->commision*$price/100 ;
            $order->delivery_fees =  $restaurant->delivery_fees;
            $order->save();
            //notification
            $notification = $restaurant->notifications()->create([
                'title' => Auth::user()->name . 'يوجد طلب جديد من',
                'content' => $order->id . ' # يوجد طلب',
            ]);
            sendNotification( $notification, $order);
            return apiResponse(1, 'تم بنجاح', $order);
        }else{
            $order->delete();
            return apiResponse(1, $restaurant->minimum_order.'لا يمكن تنفيذ طلبك ,سعر الطلب لايمكن ان يقل عن ');
        }
    }


    public function orderDetails($id)
    {
        try {
            $orderDetails = request()->user()->orders()->with('restaurant', 'products')->findOrFail($id);
            return apiResponse(1, 'تم بنجاح', $orderDetails);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return apiResponse(0, 'لا يوجد بيانات', null);
        }
    }
    public function recentOrders()
    {
        $recentOrders = request()->user()->orders()->with('restaurant', 'products')
            ->whereIn('status', ['pending'])
            ->latest()->paginate(15);
        return apiResponse(1, 'تم بنجاح', $recentOrders);
    }
    public function latestOrders()
    {
        $latestOrders = request()->user()->orders()->with('restaurant', 'products')
            ->whereIn('status', ['delivered', 'diclined', 'rejected'])->latest()->paginate(15);
        return apiResponse(1, 'تم بنجاح', $latestOrders);
    }

    public function deliverOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($request->status == 'delivered' && $order->status=='accepted') {
            $order->changeOrderStatus( $request->status);
            $restaurant = Restaurant::find($order->restaurant_id);
            $notification = $restaurant->notifications()->create([
                'title' => Auth::user()->name . 'قام العميل بالرد على طلبك',
                'content' => $order->id . ' # تم توصيل الطلب',
            ]);
            sendNotification($notification, $order);
            return apiResponse(1, 'تم بنجاح', $order);
        }else{
            return apiResponse(0, 'حاول مرة اخرى', $order);
        }
    }
    public function rejectOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if (($request->status == 'rejected'||$request->status =='declined') && $order->status=='accepted') {
            $order->changeOrderStatus( $request->status && $order->status=='accepted');
            $restaurant = Restaurant::find($order->restaurant_id);
            $notification = $restaurant->notifications()->create([
                'title' => Auth::user()->name . 'قام العميل بالرد على طلبك',
                'content' => $order->id . ' # تم رفض الطلب',
            ]);
            sendNotification( $notification, $order);
            return apiResponse(1, 'تم بنجاح', $order);
        }else{
            return apiResponse(0, 'حاول مرة اخرى', $order);
        }
    }
}
