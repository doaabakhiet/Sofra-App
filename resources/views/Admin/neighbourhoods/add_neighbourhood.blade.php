@inject('cities', 'App\Models\City')
@extends('layouts.admin')
@section('title')
    Admin | Add Neighbourhoods
@endsection
@section('content')
    <section class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Neighbourhoods</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                            <li class="breadcrumb-item "><a
                                    href="{{ Route('dashboard.neighbourhoods.index') }}">Neighbourhoods</a></li>
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
                    <h3 class="card-title">Add New Neighbourhoods</h3>

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
                            {!! Form::open(['route' => 'dashboard.neighbourhoods.store', 'method' => 'post']) !!}
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
                                {!! Form::select('city_id', $cities->pluck('name', 'id')->toArray(), null, [
                                    'class' => 'custom-select',
                                    'placeholder' => 'Pick City',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card -->

        </section>
    @endsection
