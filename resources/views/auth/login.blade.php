@extends('user.layouts.authapp')
@section('content')
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="login-box">
                    <div class="login-box-card">
                        <h2>Login</h2>
                        <p></p>
                        <form id="dataForm" method="POST" action="{{ route('login') }}">
                            @csrf
                            @if (session('message'))
                                <div class="help-block alert alert-{{session('alert-class')}} text-left">
                                    <span>{{session('message')}}</span>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="">Email</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('messages.email')" required aria-describedby="email" autofocus="" tabindex="1">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Password</label>
                                <input id="password" type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="@lang('messages.password')"  required aria-describedby="password">
                                <!-- <span toggle="#password-field" class="fa fa-fw fa-eye-slash pass_field_icon toggle-password password-eye-login"></span> -->
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button>Login</button>
                            </div>
                        </form>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                        <span>Login with your Social account</span>
                        <div class="Social-Box">
                                <a rel="nofollow" href="{{ url('/login/facebook') }}"
                                    title="Connect with Facebook" style="margin: 10px;"
                                    data-provider="Facebook">
                                    <img src="{{ URL::asset('public/images/facebook.png')}}" alt="">Facebook
                                </a>
                                <a rel="nofollow" href="{{ url('/login/google') }}" title="Connect with Google"
                                    style="margin: 10px;" data-provider="Google">
                                    <img src="{{ URL::asset('public/images/google.png')}}" alt="">Google
                                </a>  
                        </div>
                        <div class="sign-box">
                            <a href="{{ url('/register') }}">New User? SIGN UP</a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
    }, "Please enter valid email address");
    $(document.body).on('click',"#submitBtn",function(){
        if($("#dataForm").length){
            $("#dataForm").validate({
                onfocusout: false,
                errorElement: 'div',
                errorClass: 'text-danger',
                ignore: [],
                    rules: {
                        "email":{
                            required:true,
                            email:true,
                        },
                        "password":{
                            required:true,
                        },
                    },
                    messages: {
                        "email":{
                            required:'Please enter email address.',
                        },
                        "password":{
                            required:"Please enter password.",
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".input-group"));
                    },
                    submitHandler: function(form,e) {
                        e.preventDefault();
                        // $("#submitBtn").html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                        form.submit();
                    },
            });
        }
    });
  </script>
@endsection
