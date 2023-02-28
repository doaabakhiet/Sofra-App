@extends('layouts.admin')
@section('title')
    Admin | Roles
@endsection
{{-- @section('page_title')
 
@endsection --}}
@section('content')
<section class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1>Roles</h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                  <li class="breadcrumb-item ">Roles</li>
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
                        <h3 class="card-title">Roles</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    @include('flash::message')
                                    <a href="{{ Route('dashboard.roles.create') }}"
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
                                                    colspan="1" aria-label="CityName: activate to sort column ascending">
                                                    Roles Name
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
                                            @forelse($roles as $item)
                                                <tr class="odd">
                                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td><a href="{{ Route('dashboard.roles.edit', $item->id) }}"
                                                            class="btn btn-outline-primary"><i class="fa fa-pen"></i></a></td>
                                                    <td>
                                                        {!! Form::open([
                                                            'route' => ['dashboard.roles.destroy', $item->id],
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
                                {{ $roles->links() }}
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