<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function newOrders()
    {
        $newOrders = request()->user()->orders()->with('client')
            ->where('status', 'pending')->latest()->paginate(15);
        return apiResponse(1, 'تم بنجاح', $newOrders);
    }
    public function recentOrders()
    {
        $recentOrders = request()->user()->orders()->with('client')
            ->whereIn('status', ['accepted', 'rejected'])
            ->latest()->paginate(15);
        return apiResponse(1, 'تم بنجاح', $recentOrders);
    }
    public function lastOrders()
    {
        $recentOrders = request()->user()->orders()->with('client')
            ->whereIn('status', ['rejected', 'delivered', 'declined'])
            ->latest()->paginate(15);
        return apiResponse(1, 'تم بنجاح', $recentOrders);
    }
    public function acceptOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($request->status == 'accepted' && $order->status=='pending') {
            $order->changeOrderStatus( $request->status);
            $client = Client::find($order->client_id);
            $notification = $client->notifications()->create([
                'title' => request()->user()->restaurant_name . 'قام المطعم بالرد على طلبك',
                'content' => $order->id . ' # تم تاكيد الطلب',
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
        if ($request->status == 'rejected' && $order->status=='pending') {
            $order->changeOrderStatus( $request->status);
            $client = Client::find($order->client_id);
            $notification = $client->notifications()->create([
                'title' => request()->user()->restaurant_name . 'قام المطعم بالرد على طلبك',
                'content' => $order->id . ' # تم رفض الطلب',
            ]);
            sendNotification($notification, $order);
            return apiResponse(1, 'تم بنجاح', $order);
        }else{
            return apiResponse(0, 'حاول مرة اخرى', $order);
        }
    }
    public function confirmDeliveredOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($request->status == 'confirmed' && $order->status=='delivered') {
            $order->changeOrderStatus( $request->status);
            $client = Client::find($order->client_id);
            $notification = $client->notifications()->create([
                'title' => request()->user()->restaurant_name . 'قام المطعم بالرد على طلبك',
                'content' => $order->id . ' # تم تاكيد استلام الطلب',
            ]);
            sendNotification($notification, $order);
            return apiResponse(1, 'تم بنجاح', $order);
        }else{
            return apiResponse(0, 'حاول مرة اخرى', $order);
        }
    }
}
