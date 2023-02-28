@extends('layouts.admin')
@section('title')
    Admin | Resturants
@endsection
{{-- @section('page_title')
 
@endsection --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Resturants</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                        <li class="breadcrumb-item ">Resturants</li>
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
                        <h3 class="card-title">Resturants</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-5 pt-3">
                                    <form action="{{ Route('dashboard.restaurants.index') }}" method="get" id="form">
                                        <div class="form-group has-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" class="form-control" placeholder="Search" name="search">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 show-data">
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
                                                    aria-label="ResturantsName: activate to sort column ascending">
                                                    Resturant Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Email: activate to sort column ascending">
                                                    Email
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Phone: activate to sort column ascending">
                                                    Phone
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="Neighbourhood: activate to sort column ascending">
                                                    Neighbourhood
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Edit: activate to sort column ascending">
                                                    Activate/Deactivate</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1"
                                                    aria-label="Engine Delete: activate to sort column ascending">
                                                    Delete</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($restaurants as $item)
                                                <tr class="odd">
                                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}
                                                    </td>
                                                    <td>{{ $item->restaurant_name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>{{ $item->neighborhoods->name }}</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="hidden" name="clientID"
                                                                value="{{ $item->id }}" />
                                                            <input type="checkbox" class="js-switch"
                                                                value="{{ $item->status }}" name="active"
                                                                id="toggleactive{{ $item->id }}"
                                                                onchange="changeStatus({{ $item->id }})"
                                                                {{ $item->status == '1' ? 'checked' : '' }} />
                                                        </div>
                                                    </td>
                                                    <td><a href="{{ Route('dashboard.restaurants.show', $item->id) }}"
                                                            class="btn btn-success" title="show"><i
                                                                class="fas fa-eye"></i></a></td>

                                                    <td>
                                                        {!! Form::open([
                                                            'route' => ['dashboard.restaurants.destroy', $item->id],
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
                                {{ $restaurants->links() }}
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function changeStatus(id) {
            $.ajax({
                type: "post",
                url: "{{ Route('dashboard.restaurant.toggle-active') }}",
                data: {
                    'id': id
                },
                dataType: "json",
                success: function(response) {}
            });
        }
        $(document).ready(function() {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

            elems.forEach(function(html) {
                var switchery = new Switchery(html, {
                    color: 'rgb(80 111 237)',
                    jackColor: '#9decff',
                    size: 'small'
                });
            });
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
                $('.alert').fadeOut('fast');
            }, 3000);
        });
        $('#search').onkeyup = function(e) {
            if (e.keyCode === 13) {
                $('form').submit(); // your form has an id="form"
            }
        }
    </script>
@endpush
