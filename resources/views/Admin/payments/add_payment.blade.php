@extends('layouts.admin')
@section('title')
    Admin | Add Payments
@endsection
@section('content')
    <section class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                            <li class="breadcrumb-item "><a href="{{ Route('dashboard.payments.index') }}">Payments</a></li>
                            <li class="breadcrumb-item active">Store</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Payments</h3>

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
                        <div class="col-sm-12">
                            {!! Form::open(['route' => 'dashboard.payments.store', 'method' => 'post']) !!}
                            @csrf
                            <div class="form-group">
                                @error('restaurant_id')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                                <br />
                                {!! Form::select('restaurant_id', $restaurants->pluck('restaurant_name', 'id')->toArray(), null, [
                                    'class' => 'custom-select',
                                    'placeholder' => 'اختر المطعم',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <div class=" commissions">
                                    <div class="row h3 pt-2 text-success">
                                        <div class="col-sm-3">
                                            مبيعات المطعم
                                        </div>
                                        <div class="col-sm-3 ">
                                            عمولة التطبيق
                                        </div>
                                        <div class="col-sm-3">
                                            ما تم سداده
                                        </div>
                                        <div class="col-sm-3">
                                            المتبقى
                                        </div>
                                    </div>
                                    <div class="row h6 pt-2">
                                        <div class="col-sm-3 restaurant_sales"></div>
                                        <div class="col-sm-3 appfees"></div>
                                        <div class="col-sm-3 feesPaid"></div>
                                        <div class="col-sm-3 remainingfees"></div>
                                    </div>
                                </div>
                                @error('fees_paid')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                                <br>
                                {{ Form::label('المبلغ', null, ['class' => 'control-label']) }}
                                {{ Form::number('fees_paid', null, array_merge(['class' => 'form-control payment'])) }}
                                <span class="text-danger font-weight-bold paynotes"></span>
                            </div>
                            <div class="form-group">
                                @error('notes')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                                <br>
                                {{ Form::label('ملاحظات', null, ['class' => 'control-label']) }}
                                {{ Form::textarea('notes', null, array_merge(['class' => 'form-control', 'id' => 'editor'])) }}
                            </div>
                            <div class="form-group">
                                @error('payment_method')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                                <br>
                                {{ Form::label('payment_method', null, ['class' => 'control-label']) }}
                                <br>
                                <div class="row">
                                    <div class="col-sm-2 col-lg-2 col-md-2">
                                        {{ Form::radio('payment_method', 'pay_online') }}
                                        {{ Form::label('دفع الكترونى', null, ['class' => 'control-label']) }}
                                    </div>
                                    <div class="col-sm-2 col-lg-2 col-md-2">
                                        {{ Form::radio('payment_method', 'cash_on_delivery') }}
                                        {{ Form::label('دفع كاش', null, ['class' => 'control-label']) }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                            {!! Form::close() !!}
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
    @push('javascript')
        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(".commissions").css("display", "none");
                var paid = 0,appfees=0,remaining_fees=0;

                $('select').on('change', function() {
                    $(".paynotes").text('');
                    var id = this.value;
                    $.ajax({
                        type: "GET",
                        url: "{!! url('dashboard/payments/"+id+"') !!}",
                        dataType: 'json',
                        success: function(response) {
                            $(".commissions").css("display", "block");
                            console.log(response.res)
                            $('.restaurant_sales').text(response.total_restaurant_sales);
                            $('.appfees').text(response.appfees);
                            $('.feesPaid').text(response.paid);
                            $('.remainingfees').text(response.remaining_fees);
                            remaining_fees = parseInt(response.remaining_fees);
                            appfees=response.appfees;
                        }
                    });
                });
                $('.payment').on('keyup', function() {
                    // total = parseInt(paid) + parseInt($('.payment').val());
                    paid=parseInt($('.payment').val());

                    if (paid>remaining_fees) {
                        $remaining=paid-remaining_fees;
                        $(".paynotes").text($remaining+"المبلغ اكبر من عمولة التطبيق سيتبقى لك ");
                    }
                    else{
                        $(".paynotes").text('');
                    }
                });
            });
            var allEditors = document.getElementById('editor');
            ClassicEditor.create(allEditors, {
                alignment: {
                    options: ['left', 'right', 'center', 'justify']
                }
            });
        </script>
    @endpush
