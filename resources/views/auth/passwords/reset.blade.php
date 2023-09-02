@extends('user.layouts.authapp')

@section('content')
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="login-box">
                    <div class="login-box-card">
                        <h2>Reset password</h2>
                        <p></p>

                        <form class="auth-login-form mt-2" method="POST" id="passwordReset" action="{{ route('password.update') }}">
                          @csrf
                            @if (session('status'))
                              <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                              </div>
                            @endif

                            <input type="hidden" name="token" value="{{ $token }}">
                              <div class="form-group">
                                <label for="login-email">Email</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{old('email')}}" placeholder="Email" required aria-describedby="email" autofocus="" tabindex="1">
                                @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                                @endif
                              </div>
                              <div class="form-group">                                  
                                  <label for="Password">Password</label>
                                  <input id="password" type="password" class="form-control form-control-merge {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required aria-describedby="password" tabindex="2" >
                                  @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                  @endif
                              </div>
                              <div class="form-group">                                  
                                  <label for="Confirm Password">Confirm Password</label>
                                  <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control form-control-merge @error('password-confirm') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" tabindex="3">
                                  @if ($errors->has('password'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              <div class="form-group">       
                                  <button type="submit" id="resetBtn" tabindex="4">Set New Password</button>
                              </div>
                          </form>
                          <p class="text-center mt-2"><a href="{{url('login')}}"><i data-feather="chevron-left"></i> Back to login</a></p>


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
                      error.insertAfter(element.closest(".form-control"));
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
