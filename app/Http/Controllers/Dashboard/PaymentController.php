<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\FeesPaid;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use DateTime;

class PaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:feespaid-list|feespaid-create|feespaid-edit|feespaid-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:feespaid-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:feespaid-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:feespaid-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = FeesPaid::paginate(5);
        return view('Admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $restaurantsAccounts = FeesPaid::pluck('restaurant_id');
        $restaurants = Restaurant::all();
        return view('Admin.payments.add_payment', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'restaurant_id' => 'required',
            'fees_paid'=>'required',
            'payment_method'=>'required',
            'notes'=>'required'
        ]);
        
        $restaurant = Restaurant::find($request->restaurant_id);
        $remaining_fees = $restaurant->commission()->sum('fees_paid') +$request->feespaid;
        $restaurant_payment = $restaurant->commission()->create([
            'fees_paid'=>$request->fees_paid,
            'remaining_fees'=>$restaurant->orders()->sum('app_commission')-$restaurant->commission()->sum('fees_paid'),
            'notes'=>$request->notes,
            'payment_method'=>$request->payment_method,
            'payment_date'=>new DateTime(),
            'status'=>$remaining_fees>=$restaurant->orders()->sum('app_commission') ?'1':'0'
        ]);
        flash()->success('Payments For '.$restaurant->restaurant_name.' Added Successfully')->important();
        return redirect(route('dashboard.payments.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($restaurantId)
    {
        $restaurant=Restaurant::find($restaurantId);
        
        // return response()->json(['res'=>$restaurantId]);
        return response()->json([
            'total_restaurant_sales' =>$restaurant->orders()->sum('total_price'),
            'appfees' =>$restaurant->orders()->sum('app_commission'),
            'paid' => $restaurant->commission()->sum('fees_paid'),
            'remaining_fees' => $restaurant->orders()->sum('app_commission') - $restaurant->commission()->sum('fees_paid')
        ]);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feespaid = FeesPaid::findOrFail($id);
        return view('Admin.payments.edit_payment', compact('feespaid'));
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
            'fees_paid'=>'required',
            'payment_method'=>'required',
            'notes'=>'required'
        ]);
        $feespaid=FeesPaid::find($id);
        $restaurant=Restaurant::find($feespaid->restaurant_id);
        $remaining_fees = $restaurant->commission()->sum('fees_paid') +$request->feespaid;
        $feespaid->update([
            'fees_paid'=>$request->fees_paid,
            'remaining_fees'=>$feespaid->restaurant->orders()->sum('app_commission')-$restaurant->commission()->sum('fees_paid'),
            'notes'=>$request->notes,
            'payment_method'=>$request->payment_method,
            'payment_date'=>new DateTime(),
            'status'=>$remaining_fees>=$restaurant->orders()->sum('app_commission') ?'1':'0'
        ]);
        flash()->success('Payments For  Updated Successfully')->important();
        return redirect(route('dashboard.payments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feespaid = FeesPaid::find($id)->delete();
        flash()->success('Payment For The Restaurant Deleted Successfully')->important();
        return back();
    }
}
