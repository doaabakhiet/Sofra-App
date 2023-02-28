@extends('layouts.admin')
@section('title')
    Admin | Manage Your Password
@endsection
{{-- @section('page_title')
 
@endsection --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Your Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                        <li class="breadcrumb-item ">Manage Your Password</li>
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
                        <h3 class="card-title">Manage Your Password</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                @include('flash::message')
                                {!! Form::model(null, ['url' => ['dashboard/update-password'], 'method' => 'put']) !!}
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    @error('old_password')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                    {{ Form::label('old_password', null, ['class' => 'control-label']) }}
                                    {{ Form::password('old_password', ['class' => 'form-control']) }}
                                </div>

                                <div class="form-group">
                                    @error('password')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                    {{ Form::label('password', null, ['class' => 'control-label']) }}
                                    {{ Form::password('password', array_merge(['class' => 'form-control'])) }}
                                </div>

                                <div class="form-group">
                                    @error('confirm_password')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                    {{ Form::label('confirm password', null, ['class' => 'control-label']) }}
                                    {{ Form::password('confirm_password', array_merge(['class' => 'form-control'])) }}
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
