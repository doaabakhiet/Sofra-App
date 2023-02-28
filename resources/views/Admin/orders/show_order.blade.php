@extends('layouts.admin')
@section('title')
    Admin | Show Orders
@endsection
@section('content')
    <section class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                            <li class="breadcrumb-item "><a href="{{ Route('dashboard.orders.index') }}">Orders</a>
                            </li>
                            <li class="breadcrumb-item active">Show Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fas fa-globe"></i> Sofra
                      <small class="float-right">Date: {{$order->created_at}}</small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    From
                    <address>
                      <strong>{{$order->client->name}}.</strong><br>
                      {{$order->client->neighborhoods->name}}<br>
                      {{$order->client->neighborhoods->cities->name}}<br>
                      Phone: {{$order->client->phone}}<br>
                      Email: {{$order->client->email}}
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    To
                    <address>
                      <strong>{{$order->restaurant->restaurant_name}}</strong><br>
                      {{$order->restaurant->neighborhoods->name}}<br>
                      {{$order->restaurant->neighborhoods->cities->name}}<br>
                      Phone: {{$order->restaurant->phone}}<br>
                      Email: {{$order->restaurant->email}}
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{$order->id}}</b><br>
                    <br>
                    <b>Order ID:</b> {{$order->id}}<br>
                    {{-- <b>Payment Due:</b> 2/22/2014<br> --}}
                    <b>Account:</b> {{$order->payment_method}}
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <h4 class="text-primary"><b>Order Status</b> {{$order->status}}</h4>
  
                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        {{-- <th>Serial #</th> --}}
                        <th>Description</th>
                        <th>Subtotal</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($order->products as $item)
                      <tr>
                        <td>{{$item->pivot->quantity}}</td>
                        <td>{{$item->name}}</td>
                        {{-- <td>455-981-221</td> --}}
                        <td>{{$item->pivot->order_description}}</td>
                        <td>${{$item->pivot->price}}</td>
                      </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
  
                <div class="row">
                  <!-- accepted payments column -->
                  <div class="col-6">
                    <p class="lead">Payment Methods:</p>
                    <img src="../../dist/img/credit/visa.png" alt="Visa">
                    <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                    <img src="../../dist/img/credit/american-express.png" alt="American Express">
                    <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
  
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                      Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                      plugg
                      dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                    </p>
                  </div>
                  <!-- /.col -->
                  <div class="col-6">
                    <p class="lead">Amount Due {{date('d/m/Y')}}</p>
                    <div class="table-responsive">
                      <table class="table">
                        <tbody><tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>${{$order->price}}</td>
                        </tr>
                        <tr>
                          <th>Tax ({{$order->app_commission}}%)</th>
                          <td>${{($order->app_commission *$order->price)/100}}</td>
                        </tr>
                        <tr>
                          <th>Delivery Fees:</th>
                          <td>{{$order->delivery_fees}}</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>${{$order->total_price}}</td>
                        </tr>
                      </tbody></table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
  
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    <a href="#"  rel="noopener" target="_blank" class="print btn btn-default"><i class="fas fa-print"></i> Print</a>
                    {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                      Payment
                    </button> --}}
                    {{-- <a href="{{url('dashboard/order/invoice/'.$order->id)}}" class="btn btn-primary float-right" style="margin-right: 5px;">
                      <i class="fas fa-download"></i> view
                    </a> --}}
                    {{-- <a href="{{url('dashboard/order/invoice/'.$order->id)}}" class="btn btn-primary text-white float-end">Download Invoice</a> --}}

                    {{-- <a href="{{url('dashboard/order/invoice/'.$order->id)}}"  class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-download"></i> Generate PDF
                      </a> --}}
                  </div>
                </div>
              </div>
        </section> 
    @endsection

    @push('javascript')
    <script type="text/javascript">
         $(document).ready(function() {
          $('.print').click(function (e) { 
            e.preventDefault();
            window.print()
          });
         });
    </script>
@endpush