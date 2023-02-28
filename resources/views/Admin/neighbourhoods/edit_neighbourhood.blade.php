@inject('cities', 'App\Models\City')
@extends('layouts.admin')
@section('title')
    Admin | Update Neighbourhoods
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
                        <li class="breadcrumb-item "><a href="{{ Route('dashboard.neighbourhoods.index') }}">Neighbourhoods</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Neighbourhoods</h3>

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
                    {!! Form::model($neighborhood,['route' => ['dashboard.neighbourhoods.update', $neighborhood->id], 'method' => 'put']) !!}
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        @error('name')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                        {{ Form::label('name', null, ['class' => 'control-label']) }}
                        {{ Form::text('name', $neighborhood->name, array_merge(['class' => 'form-control'])) }}
                      
                    </div>
                    <div class="form-group">
                        {!! Form::select('city_id', $cities->pluck('name', 'id')->toArray(), null, [
                            'class' => 'custom-select',
                            'placeholder' => 'Pick City',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
    <!-- /.card -->

</section>
@endsection
