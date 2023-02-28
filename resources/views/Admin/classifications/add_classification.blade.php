@extends('layouts.admin')
@section('title')
    Admin | Add Classifications
@endsection
@section('content')
    <section class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Classifications</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                            <li class="breadcrumb-item "><a href="{{ Route('dashboard.classifications.index') }}">Classifications</a></li>
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
                    <h3 class="card-title">Add New Classifications</h3>

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
                            {!! Form::open(['route' => 'dashboard.classifications.store', 'method' => 'post']) !!}
                            @csrf
                            <div class="form-group">
                                {{ Form::label('name', null, ['class' => 'control-label']) }}
                                <br>
                                @error('name')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                                {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}

                            </div>
                            {{-- <div class="form-group">
                        {!! Form::select('governate_id',$governorates->pluck('name','id')->toArray(),null,[
                            'class' => 'custom-select',
                            'placeholder' => 'Pick Governorate'
                        ]) !!}
                      
                    </div> --}}
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
