@extends('layouts.admin')
@section('title')
    Admin | Add Roles
@endsection
@section('content')
    <section class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Roles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                            <li class="breadcrumb-item "><a href="{{ Route('dashboard.roles.index') }}">Roles</a></li>
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
                    <h3 class="card-title">Add New Roles</h3>

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
                            {!! Form::open(['route' => 'dashboard.roles.store', 'method' => 'post']) !!}
                            @csrf
                            <div class="form-group">
                                {{ Form::label('name', null, ['class' => 'control-label']) }}
                                <br>
                                @error('name')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                                {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}

                            </div>
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <br />
                                <br />
                                <div class="row">
                                    @foreach ($permission as $value)
                                        <div class="col-sm-3 ">
                                            <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                                {{ $value->name }}</label>
                                            <br />
                                        </div>
                                    @endforeach
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
