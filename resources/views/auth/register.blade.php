@extends('user.layouts.authapp')
@section('content')
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="login-box">
                    <div class="login-box-card">
                        <h2>Registration</h2>
                        <p></p>
                        <form method="POST" class="auth-login-form mt-2" id="dataForm" action="{{ route('register') }}">
                            @csrf
                                @if (session('message'))
                                <div class="help-block alert alert-{{session('alert-class')}} text-left">
                                    <span>{{session('message')}}</span>
                                </div>
                                @endif
                                
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required aria-describedby="email" autofocus="" tabindex="1">                                    
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input id="password" type="password" class="form-control form-control-merge {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required aria-describedby="password" tabindex="2" >
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control form-control-merge @error('password-confirm') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" tabindex="3">                                        
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>       
                                <div class="form-group">                         
                                <button type="submit" id="submitBtn" tabindex="4">Sign up</button>
                                </div>       
                            </form>
                            <div class="sign-box">
                                <a href="{{ url('/login') }}">Login</a>
                            </div> 

                    </div>
                </div>
            </div>    
        </div>        
    </div>        
</section>    


@endsection
@section('css')
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

        $.validator.addMethod("lettersonlys", function(value, element) {
            return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
        }, "Letters only please");

        $.validator.addMethod("password_length", function(value, element) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^.()_-])[A-Za-z\d@$!%*?&#^.()_-]{8,18}$/.test(value);
        }, "Enter combination of at least 8 number, letters ,special character and atleast one capital letter.");

        $(document.body).on('click',"#submitBtn",function(){
            if($("#dataForm").length){
                $("#dataForm").validate({
                // onfocusout: false,
                errorElement: 'div',
                errorClass: 'text-danger',
                ignore: [],
                    rules: {
                        "name":{
                            required:true,
                            lettersonlys:true,
                            minlength: 2,
                            maxlength: 50,
                        },
                        "email":{
                            required:true,
                            email:true,
                            remote: {
                                url: SITE_URL + '/check-email-exsist',
                                type: "get"
                            }
                        },
                        "password":{
                            required:true,
                            password_length:true,
                        },
                        "password_confirmation":{
                            required:true,
                            equalTo:'#password',
                        },
                        "privacy":{
                            required:true,
                            maxlength: 1,
                        }
                    },
                    messages: {
                        "email":{
                            required:'Please enter email address.',
                            remote:"Provided email already used by some one.",
                        },
                        "name":{
                            required:"Please enter name.",
                            lettersonlys:"Please enter only alphabetic characters.",
                            maxlength:"Please enter not more than 30 characters.",
                        },
                        "password_confirmation":{
                            required:"Please enter confirm password.",
                            equalTo: "Please enter same as password.",
                        },
                        "password":{
                            required:"Please enter password.",
                        },
                        "privacy":{
                            required:"Please confirm privacy.",
                        }
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                    submitHandler: function(form,e) {
                        e.preventDefault();
                        // $("#submitForm").html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                        form.submit();
                    },
                });
            }
        });

    </script>
@endsection
