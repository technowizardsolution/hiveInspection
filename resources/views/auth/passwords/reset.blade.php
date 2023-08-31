@extends('user.layouts.authapp')

@section('content')
<div class="app-content content ">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
          <div class="auth-wrapper auth-v2">
              <div class="auth-inner row m-0">
                  <a class="brand-logo" href="javascript:void(0);">
                      <img src="{{ URL::asset('resources/uploads/logo/Logo7.png')}}" alt="" height="28">
                      {{-- <h2 class="brand-text text-primary ml-1">{{ config('app.name', 'Laravel') }}</h2> --}}
                  </a>
                  <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                      <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{ URL::asset('/resources/assets/app-assets/images/pages/reset-password-v2-dark.svg')}}" alt="Login V2" /></div>
                  </div>
                  <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                          <h2 class="card-title font-weight-bold mb-1">Reset Password 🔒</h2>
                          <p class="card-text mb-2">Your new password must be different from previously used passwords</p>
                          <form class="auth-login-form mt-2" method="POST" id="passwordReset" action="{{ route('password.update') }}">
                          @csrf
                            @if (session('status'))
                              <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                              </div>
                            @endif

                            <input type="hidden" name="token" value="{{ $user->password_reset_token }}">
                              <div class="form-group">
                                <div class="d-flex justify-content-between">
                                  <label class="form-label" for="login-email">Email</label>
                                </div>
                                <div class="input-group input-group-merge">
                                  <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="@if($user->email) {{$user->email}} @else {{old('email')}}@endif" placeholder="Email" required aria-describedby="email" autofocus="" tabindex="1">
                                </div>
                                @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                                @endif
                              </div>
                              <div class="form-group">
                                  <div class="d-flex justify-content-between">
                                      <label for="login-password">Password</label>
                                  </div>
                                  <div class="input-group input-group-merge form-password-toggle">
                                      <input id="password" type="password" class="form-control form-control-merge {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required aria-describedby="password" tabindex="2" >
                                      <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
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
                                      <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control form-control-merge @error('password-confirm') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" tabindex="3">
                                      <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                  </div>
                                  @if ($errors->has('password'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              <button type="submit" id="resetBtn" class="btn btn-primary btn-block" tabindex="4">Set New Password</button>
                          </form>
                          <p class="text-center mt-2"><a href="{{url('login')}}"><i data-feather="chevron-left"></i> Back to login</a></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
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
    $.validator.addMethod("password_length", function(value, element) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^.()_-])[A-Za-z\d@$!%*?&#^.()_-]{8,18}$/.test(value);
    }, "Enter combination of at least 8 number, letters and special characters.");

    $(document.body).on('click',"#resetBtn",function(){
      if($("#passwordReset").length){
          $("#passwordReset").validate({
          onfocusout: false,
          errorElement: 'span',
          errorClass: 'text-danger',
          ignore: [],
              rules: {
                  "email":{
                    required:true,
                  },
                  "password":{
                      required:true,
                      password_length:true,
                  },
                  "password_confirmation":{
                      required:true,
                      equalTo:'#password',
                  },

                  },
                  messages: {
                      "password_confirmation":{
                          required:"Please enter confirm password.",
                          equalTo: "Please enter same as password.",
                      },
                      "password":{
                          required:"Please enter password.",
                      },
                      "email":{
                        required:"Please enter email.",
                      },

                  },
                  errorPlacement: function(error, element) {
                      error.insertAfter(element.closest(".input-group"));
                  },
                      submitHandler: function(form,e) {
                          e.preventDefault();
                          $("#submitForm").html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
                          form.submit();
                      },
              });
      }
    });
  </script>
@endsection
