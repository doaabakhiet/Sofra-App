@extends('layouts.admin')
@section('title')
    Admin | Show Restaurants
@endsection
@section('content')
    <section class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Restaurants</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                            <li class="breadcrumb-item "><a href="{{ Route('dashboard.restaurants.index') }}">Restaurants</a>
                            </li>
                            <li class="breadcrumb-item active">Show Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $restaurant->restaurant_name }} Details</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Minimum Order</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{ $restaurant->minimum_order }}
                                                $</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Delivery Fees</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{ $restaurant->delivery_fees }}
                                                $</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">status</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{ $restaurant->status == '1' ? 'مفتوح' : 'مغلق' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4>{{ $restaurant->restaurant_name }}</h4>
                                    <div class="post">
                                        <div class="">
                                            {{-- <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image"> --}}
                                            <span class="username">
                                                <h5>{{ $restaurant->email }}</h5>
                                            </span><br />
                                            {{-- <span class="description">{{$restaurant->email}}</span> --}}
                                            <span class="description">{{ $restaurant->delivery_phone }}</span><br />
                                            <span
                                                class="description">{{ $restaurant->delivery_watsapp_number }}</span><br />
                                            <span class="description"><b>العنوان:</b>
                                                {{ $restaurant->neighborhoods->name }}</span><br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <img src="{{ asset('images/' . $restaurant->image) }}" class="img-thumbnail" height="200"
                                width="200" alt="logo">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12 col-md-12 col-lg-12 order-1 order-md-2">
                            @if(!count($restaurant->products))
                            <h2>There is No Products </h2>
                            @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Offer Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($restaurant->products as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset('images/' . $item->image) }}" height="60"
                                            width="60" alt="logo"></td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->price}} $</td>
                                        <td>{{$item->has_offer=='1'?$item->offer_price:'No Offer'}} $</td>
                                    </tr>        
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            @endif
                            
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
    @endsection
