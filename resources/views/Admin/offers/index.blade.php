@extends('layouts.admin')
@section('title')
    Admin | Offer
@endsection
{{-- @section('page_title')
 
@endsection --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Offers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                        <li class="breadcrumb-item ">Offers</li>
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
                        <h3 class="card-title">Offers</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    @include('flash::message')
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5 pt-3">
                                    <form action="{{ Route('dashboard.offers.index') }}" method="get" id="form">
                                        <div class="form-group has-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" class="form-control" placeholder="Search" name="search">
                                        </div>
                                    </form>
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
                                                    aria-label="OfferName: activate to sort column ascending">
                                                    Image
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="OfferName: activate to sort column ascending">
                                                    Offer Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Description: activate to sort column ascending">
                                                    Description</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="StartDate: activate to sort column ascending">
                                                    Start Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="EndDate: activate to sort column ascending">
                                                    End Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="Engine Delete: activate to sort column ascending">
                                                    Delete</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($offers as $item)
                                                <tr class="odd">
                                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}
                                                    </td>
                                                    <td><img src="{{asset('images/'.$item->image )}}" alt=""> </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->description }}</td>
                                                    <td>{{ $item->start_date }}</td>
                                                    <td>{{ $item->end_date }}</td>
                                                    <td>
                                                        {!! Form::open([
                                                            'route' => ['dashboard.offers.destroy', $item->id],
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
                                {{ $offers->links() }}
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
        $('#search').onkeyup = function(e) {
            if (e.keyCode === 13) {
                $('form').submit(); // your form has an id="form"
            }
        }
    </script>
@endpush
