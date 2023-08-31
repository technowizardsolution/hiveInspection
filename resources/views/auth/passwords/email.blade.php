@extends('user.layouts.authapp')

@section('content')
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="login-box">
                    <div class="login-box-card">
                        <h2>Forgot Password</h2>
                        <p></p>
                        <form class="auth-login-form mt-2" id="dataForm" action="{{ route('password.email') }}" method="POST">
                          @csrf
                          @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                          @endif
                          <div class="form-group">
                              <label class="form-label" for="email">Email</label>
                              <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required aria-describedby="email" autofocus="" tabindex="1">
                              @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                          </div>
                            <div class="form-group">
                                <button id="submitBtn" tabindex="2">Send reset link</button>
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

      $.validator.addMethod("email", function(value, element) {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
      }, "Please enter valid email address");

      $(document.body).on('click',"#submitBtn",function(){
          if($("#dataForm").length){
              $("#dataForm").validate({
                  onfocusout: false,
                  errorElement: 'span',
                  errorClass: 'text-danger',
                  ignore: [],
                      rules: {
                          "email":{
                              required:true,
                              email:true,
                          },

                      },
                      messages: {
                          "email":{
                              required:'Please enter email address.',
                          },

                      },
                      errorPlacement: function(error, element) {
                          error.insertAfter(element.closest(".form-control"));
                      },
              });
          }
      });
  </script>
@endsection
