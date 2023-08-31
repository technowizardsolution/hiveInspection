@extends('admin.layouts.app')

@section('title') {{$action}} Role User | @endsection
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Create Role user</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Create Role user
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="bs-validation">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create Role user</h4>
                            </div>
                            <div class="card-body">
                                @if(isset($roleuser))
                                {{ Form::model($roleuser, ['route' => ['roleuser.update', $roleuser->id], 'method' => 'patch','class' => 'form-horizontal','enctype'=>'multipart/form-data','id'=>'roleForm']) }}
                            @else
                                {{ Form::open(['route' => 'roleuser.store','class' => 'form-horizontal','enctype'=>'multipart/form-data','id'=>'roleForm']) }}
                            @endif
                            <div class="col-sm-12">
                                    <div class="box-body">
        
                                        <div class="form-group">
                                          <label  class=" control-label" for="geo_hub_name">Select Role <span class="colorRed"> *</span></label>
                                          <div class=""> 
                                            {{-- !!Form::select('name', $roles->pluck('name','id'),null, ['class' => 'form-control','id'=>'name'])!! --}}
                                            <select name="name" id="name" class="form-control">
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if(isset($role_id) && $role->id == $role_id) selected @endif
                                                >{{ $role->name }}</option>
                                            @endforeach
                                            </select>
                                            @if ($errors->has('name'))
                                            <span class="help-block alert alert-danger">
                                              <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                          </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                       <label  class=" control-label" for="first_name">Full Name <span class="colorRed"> *</span></label>
                                        <div class="row">
                                        <div class="col-sm-6 jointbox">
                                            {{ Form::text('first_name', Request::old('first_name'),['class'=>'form-control','placeholder'=>"First Name"]) }}
                                            @if ($errors->has('first_name'))
                                                <span class="help-block alert alert-danger">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                            <div class="col-sm-6 ">
                                                {{ Form::text('last_name', Request::old('last_name'),['class'=>'form-control','placeholder'=>"Last Name"]) }}
                                                @if ($errors->has('last_name'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                      </div>
                                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label  class=" control-label" for="email">Email <span class="colorRed"> *</span></label>
                                            <div class="">
                                               {{ Form::text('email', Input::old('email'),['class'=>'form-control','placeholder'=>"Email"]) }}
                                                @if ($errors->has('email'))
                                                <span class="help-block alert alert-danger">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label  class=" control-label" for="password">Password <span class="colorRed"> *</span></label>
                                            <div class="row">
                                                <div class="col-sm-6 jointbox">
                                                    <input autocomplete="new-password" type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{old('password')}}"/>
                                                    @if ($errors->has('password'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="{{old('confirm_password')}}"/>
                                                    @if ($errors->has('confirm_password'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="" style="border-top:0">
                                                    <div class="box-footer">
                                                        <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                                                        <button type="submit" id="createBtn" class="btn btn-primary pull-right" style="margin-left: 20px;float:right;">Create</button>
                                                        <button type="button" class="btn btn-info pull-right"  id="cancelBtn" style="float:right;">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            {{ Form::close() }}
                                  <div class="clearfix"></div>
                                      </div>                                   
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>



@endsection
@section('script')
    @if(Session::has('message'))
        <script>
        $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
        </script>
    @endif
<script>
 var SITE_URL = "<?php echo URL::to('/'); ?>";
$.validator.addMethod("email", function(value, element) {
        return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, "Please enter valid email.");
@if(!isset($roleuser))
                var rules = {"first_name":{required:true,},"last_name":{required:true,},"email":{required:true,},
                             "confirm_password":{required:true,equalTo:'#password',},
                              "password":{required:true,minlength: 6,maxlength: 20},
                              };
                var messages = {
                      "first_name":{
                          required:"Please enter first name.",
                      },
                      "last_name":{
                          required:"Please enter last name.",
                      },
                      "email":{
                          required:"Please enter email.",
                          remote:"Provided email already used by some one.",
                      },
                      "confirm_password":{
                          required:"Please enter confirm password.",
                          equalTo: "Please enter same as password.",
                      },
                      "password":{
                          required:"Please enter password.",
                      },
                    };
@else
var rules = {"first_name":{required:true,},"last_name":{required:true,},"email":{required:true,},
                             "confirm_password":{equalTo:'#password',},
                              "password":{minlength: 6,maxlength: 20},
                              };
                var messages = {
                      "first_name":{
                          required:"Please enter first name.",
                      },
                      "last_name":{
                          required:"Please enter last name.",
                      },
                      "email":{
                          required:"Please enter email.",
                          remote:"Provided email already used by some one.",
                      },
                      "confirm_password":{
                          equalTo: "Please enter same as password.",
                      },
                    };
@endif;

    $(document.body).on('click', "#roleForm", function(){
        if ($("#roleForm").length){
            $("#roleForm").validate({
            errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: rules,
                  messages: messages,
                    errorPlacement: function(error, element) {
                        if(element.is('select')){
                            error.appendTo(element.closest("div"));
                        }else{
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
            });
        }
    });

</script>
<script>
     $("#cancelBtn").click(function () {
            window.location.href = "{{route('roleuser.index')}}";
        });
</script>
@endsection
