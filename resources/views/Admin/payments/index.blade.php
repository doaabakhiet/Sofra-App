@extends('layouts.admin')
@section('title')
    Admin | Payments
@endsection
{{-- @section('page_title')
 
@endsection --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payments</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                        <li class="breadcrumb-item ">Payments</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payments</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    @include('flash::message')
                                    <a href="{{ Route('dashboard.payments.create') }}"
                                        class="btn btn-outline-primary mb-3"><i class="fa fa-plus"></i>&nbsp;Add New</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Rendering engine: activate to sort column descending">#
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="RestaurantName: activate to sort column ascending">
                                                    Restaurants Name
                                                </th>
                                                {{-- <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="RestaurantSales: activate to sort column ascending">
                                                    Restaurant Sales
                                                </th> --}}
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="AppFees: activate to sort column ascending">
                                                    App Fess
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="feespaid: activate to sort column ascending">
                                                    Fees Paid
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="remaining_fees: activate to sort column ascending">
                                                    Remaining Fees
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="PaymentMethod: activate to sort column ascending">
                                                    Payment Method
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="PaymentDate: activate to sort column ascending">
                                                    Payment Date
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Notes: activate to sort column ascending">
                                                    Notes
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Status: activate to sort column ascending">
                                                    Status
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Edit: activate to sort column ascending">
                                                    Edit</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="Engine Delete: activate to sort column ascending">
                                                    Delete</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($payments as $item)
                                                <tr class="odd">
                                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <h5 class="text-primary">{{ $item->restaurant->restaurant_name }}
                                                        </h5>
                                                    </td>
                                                    {{-- <td>{{ $item->restaurant_sales }} $</td> --}}
                                                    <td>
                                                        {{ $item->restaurant->orders->sum('app_commission') }} $
                                                    </td>
                                                    <td>{{ $item->fees_paid }} $</td>
                                                    <td>{{ $item->remaining_fees }} $</td>
                                                    <td>{{ $item->payment_method }} </td>
                                                    <td>{{ $item->payment_date}} </td>
                                                    <td>{!! $item->notes !!} </td>
                                                    {{-- <td>{{ $item->payment_date }} </td> --}}
                                                    <td>{{ $item->status == '1' ? 'Completed' : 'Not Completed' }} </td>
                                                    <td><a href="{{ Route('dashboard.payments.edit', $item->id) }}"
                                                            class="btn btn-outline-primary"><i class="fa fa-pen"></i></a>
                                                    </td>
                                                    <td>
                                                        {!! Form::open([
                                                            'route' => ['dashboard.payments.destroy', $item->id],
                                                            'method' => 'delete',
                                                            'class' => 'delete-form',
                                                        ]) !!}
                                                        <button type="submit" class="btn btn-outline-danger btndeletee"><i
                                                                class="fa fa-trash"></i></button>
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                            @empty
                                                <h2>There is No Data There</h2>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                {{ $payments->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            var confirmed = false;
            $('.delete-form').submit(function(e) {
                if (confirmed) {
                    return;
                }
                e.preventDefault();
                var deleteform = $(this);
                $.confirm({
                    title: 'Confirm!',
                    content: 'Simple confirm!',
                    buttons: {
                        confirm: function() {
                            $.alert('Confirmed!');
                            confirmed = true;
                            deleteform.submit();
                        },
                        cancel: function() {
                            $.alert('Canceled!');
                            confirmed = false;
                        }
                    }
                });
            });
            setTimeout(function() {
                $('.show-data .alert').fadeOut('fast');
            }, 3000);
        });
    </script>
@endpush
