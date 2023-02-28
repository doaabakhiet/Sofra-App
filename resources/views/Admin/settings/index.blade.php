@extends('layouts.admin')
@section('title')
    Admin | Update Settings
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard/admin') }}">Home</a></li>
                        {{-- <li class="breadcrumb-item "><a href="{{ Route('dashboard.governorate.index') }}">Settings</a></li> --}}
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Settings</h3>

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
                        @include('flash::message')
                        {!! Form::model($settings, ['route' => ['dashboard.setting.update', $settings->id], 'method' => 'put', 'method' => 'post','enctype'=>"multipart/form-data"]) !!}
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            @error('title')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            <br>
                            {{ Form::label('title', null, ['class' => 'control-label']) }}
                            {{ Form::text('title', null, array_merge(['class' => 'form-control'])) }}
                            @error('commision')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            <br>
                            {{ Form::label('commision', null, ['class' => 'control-label']) }}
                            {{ Form::number('commision', null, array_merge(['class' => 'form-control'])) }}
                            @error('favicon')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            <img src="{{ asset('images/'.$settings->favicon) }}" alt="" height="50" width="50" />
                            <br/>
                            {{ Form::label('Favicon', null, ['class' => 'control-label']) }}
                            {{ Form::file('favicon', array_merge(['class' => 'form-control'])) }}
                            @error('about_app')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            <br>
                            {{ Form::label('About', null, ['class' => 'control-label']) }}
                            {{ Form::textarea('about_us', null, array_merge(['class' => 'form-control', 'id' => 'editor'])) }}
                        </div>

                        {{-- accounts --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Accounts</h3>
                                <button type="button" class="btn btn-primary float-right " id="addAccount"><i class="fa fa-plus"></i>&nbsp;Add New Account</button>

                            </div>
                            <div class="card-body bank-accounts">
                                <div class="row">
                                    <div class="col-6">
                                        {{ Form::label('account Name', null, ['class' => 'control-label']) }}
                                    </div>
                                    <div class="col-6">
                                        {{ Form::label('account Number', null, ['class' => 'control-label']) }}
                                    </div>
                                </div>
                                @php $i=1 @endphp
                                @forelse ($settings->accounts as $item)
                                <div class="row">
                                    <div class="col-5">
                                        @error('account_name')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        <br>
                                        {{ Form::text('account_name['.$i.']', $item->account_name, array_merge(['class' => 'form-control'])) }}
                                    </div>
                                    <div class="col-5">
                                        @error('account_number')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        <br>
                                        {{ Form::text('account_number['.$i.']', $item->account_number, array_merge(['class' => 'form-control'])) }}
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger mt-4" onclick="deleteAccount(this)"  data-id="{{$item->id}}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                                @php $i++; @endphp
                                @empty
                                    <h1>No Accounts Yet.</h1>
                                @endforelse
                                <div class="new-account">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{-- <button type="button" class="btn btn-primary" id="addAccount"><i class="fa fa-plus"></i>&nbsp;Add New Account</button> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
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
        $('#addAccount').click(function (e) { 
            e.preventDefault();
            content='<div class="row new-account-content">'+
                '<div class="col-5">'+
                    '@error("account_name")'+
                        '<label class="text-danger">{{ $message }}</label>'+
                    '@enderror'+
                    '<br>'+
                    '{{ Form::text("account_name", null, array_merge(["class" => "form-control account-name"])) }}'+
                '</div>'+
                '<div class="col-5">'+
                    '@error("account_number")'+
                        '<label class="text-danger">{{ $message }}</label>'+
                    '@enderror'+
                    '<br>'+
                    '{{ Form::text("account_number", null, array_merge(["class" => "form-control account-number"])) }}'+
                '</div>'+
                '<div class="col-2">'+
                    '<button type="button" class="btn btn-outline-primary mt-4" id="createnewaccount"><i class="fa fa-plus"></i></button>'+
                    '<button type="button" class="btn btn-outline-primary mt-4 deletenewaccount">X</button>'
                '</div>'+
            '</div>';
            $('.new-account').append(content);
            $('#createnewaccount').click(function (e) { 
                e.preventDefault();
                account_name=$(this).closest('.new-account-content').find('.account-name').val();
                account_number=$(this).closest('.new-account-content').find('.account-number').val();
                $.ajax({
                    type: "POST",
                    url: "{{route('dashboard.accounts.store')}}",
                    data: {'account_number':account_number,'account_name':account_name},
                    success: function (response) {
                        $('.bank-accounts').load(location.href + " .bank-accounts");
                    }
                });
            });
            $('.deletenewaccount').click(function(){
                $(this).closest('.new-account-content').remove();
                // $('.new-account-content').load(location.href + " .new-account-content");

            });
        });
    });
    // function cancelAccount(){
    //     $(this).closest('.new-account-content').remove();
    // }
    var allEditors = document.getElementById('editor');
        // for (var i = 0; i <= allEditors.length; ++i) {
            ClassicEditor.create(allEditors, {
                alignment: {
                    options: ['left', 'right', 'center', 'justify']
                }
            });
        // }
    function deleteAccount(ele) {
            // e.preventDefault();
            id=$(ele).attr("data-id");
            // alert(id);
            var token = $("meta[name='csrf-token']").attr("content");
    
            $.ajax(
            {
                url: "/dashboard/accounts/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    console.log("it Works");
                    $('.bank-accounts').load(location.href + " .bank-accounts");
                }
            });
        }
    </script>
@endpush
