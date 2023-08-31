@extends('admin.layouts.app')
@section('title') Create User | @endsection

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Create User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Create User
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
                                <h4 class="card-title">Create User</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" id="userForm" role="form" action="{{url('admin/users')}}" method="post" enctype="multipart/form-data" >
                                @csrf                                   
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label  class="control-label" for="name">Name <span class="colorRed"> *</span></label>
                                                <div class=" jointbox">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{old('name')}}"/>
                                                    @if ($errors->has('name'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div> -->

                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="email">Email <span class="colorRed"> *</span></label>
                                                <div class="">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}"/>
                                                    @if ($errors->has('email'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="password">Password <span class="colorRed"> *</span></label>
                                                <div class="">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="password" value="{{old('password')}}"/>
                                                    @if ($errors->has('password'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="confirm_password">Confirm password <span class="colorRed"> *</span></label>
                                                <div class="">
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="confirm_password" value="{{old('confirm_password')}}"/>
                                                    @if ($errors->has('confirm_password'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
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
                                </form>
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
$(document).ajaxStart(function() { Pace.restart(); });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        var SITE_URL = "<?php echo URL::to('/'); ?>";
        $.validator.addMethod("email", function(value, element) {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        }, "Please enter valid email.");
        $.validator.addMethod("pass", function(value, element) {
        return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value);
        }, "Please enter valid password.");


        $.validator.addMethod("confirm_password", function(value, element) {
            if(value.length > 1) {
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^.()_-])[A-Za-z\d@$!%*?&#^.()_-]{8,18}$/.test(value);
            }else{
                return true;
            }
        }, "Enter combination of at least 8 number, letters ,special character and atleast one capital letter.");

        $(document.body).on('click', "#userForm", function(){
            if ($("#userForm").length){
                $("#userForm").validate({
                errorElement: 'span',
                        errorClass: 'text-red text-danger',
                        ignore: [],
                        rules: {                      
                        "email":{
                            required:true,
                            email:true,
                            remote: {
                                url: SITE_URL + '/check-email-exsist',
                                type: "get"
                            }
                        },
                        "password":{
                            required:true
                        },
                        "confirm_password":{
                            required:true,
                            equalTo:password
                        }

                    },
                    messages: {
                        "email":{
                                required:"Please enter email.",
                                remote:"Provided email already used by some one.",

                            },                         
                            "confirm_password":{
                                required:"Please enter confirm password.",
                                equalTo: "Please enter same as password.",
                            },                        
                            "password": {
                            required:"Please enter password",
                            pass:"Password should contain number,characters,special character and atleast one capital letter."
                            }
                        },
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

    $("#cancelBtn").click(function () {
        window.location.href = "{{url('admin/users')}}";
    });
</script>

@endsection
