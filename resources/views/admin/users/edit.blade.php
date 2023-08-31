
@extends('admin.layouts.app')
@section('title') Update User | @endsection

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Update User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Update User
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
                                <h4 class="card-title">Update User</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" id="empForm" action="{{url('admin/users').'/'.$user->id}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>                                           

                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="email">Email <span class="colorRed"> *</span></label>
                                                <div class="">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="@if(!empty(old('email'))){{old('email')}}@else{{$user->email}}@endif"/>
                                                    @if ($errors->has('email'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>  


                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="login-password">Password</label>
                                                </div>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input id="password" type="password" class="form-control form-control-merge {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" aria-describedby="password" tabindex="2" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="login-password">Confirm Password</label>
                                                </div>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control form-control-merge @error('password-confirm') is-invalid @enderror" name="password_confirmation" autocomplete="new-password" tabindex="3">
                                                    <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
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
                                                    <button type="submit" id="updateBtn" class="btn btn-primary pull-right" style="margin-left: 20px;float:right;">Update</button>
                                                    <button type="button" class="btn btn-info pull-right" id="cancelBtn" style="float:right;">Back</button>
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
    $("#cancelBtn").click(function () {
        window.location.href = "{{url('admin/users')}}";
    });
    $(document).ajaxStart(function() { Pace.restart(); });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.validator.addMethod("confirm_password", function(value, element) {
        if(value.length > 1) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^.()_-])[A-Za-z\d@$!%*?&#^.()_-]{8,18}$/.test(value);
        }else{
            return true;
        }
    }, "Enter combination of at least 8 number, letters ,special character and atleast one capital letter.");

    $(document.body).on('click', "#updateBtn", function(){
        var id = "{{$user->id}}";
        if ($("#empForm").length){
            $("#empForm").validate({
              errorElement: 'span',
                      errorClass: 'text-red text-danger',
                      ignore: [],
                      rules: {
                        "name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                        "email":{
                          required:true,
                          email:true,
                          remote: {
                                data:{id:id,type:'1'},
                                url: SITE_URL + '/check-email-exsist',
                                type: "get",
                            }
                        },                       
                        "password":{
                            minlength: 8,
                            maxlength: 20,
                            password_length:true,
                        },
                        "password_confirmation":{
                            equalTo:'#password',
                        }
                    },
                    messages: {
                        "email":{
                            required:"Please enter email.",
                            remote:"Provided email already used by some one.",

                        },  
                        "password": {
                          required:"Please enter password",
                          pass:"Password should contain number,characters,special character and atleast one capital letter."
                        },                       
                        "confirm_password":{
                            required:"Please enter confirm password.",
                            equalTo: "Please enter same as password.",
                        }
                      },
                      errorPlacement: function(error, element) {
                      if(element.is('select')){
                            error.appendTo(element.closest("div"));
                        }else{
                            error.insertAfter(element.closest(".form-control"));
                        }
                        error.insertAfter(element.closest(".input-group"));
                      },
              });
        }
    });   
</script>

@endsection
