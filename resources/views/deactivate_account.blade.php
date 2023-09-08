<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hive Inspection</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ URL::asset('public/images/favicon_io/favicon.ico')}}" rel="icon">
  <link href="{{URL::asset('public/images/favicon_io/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{URL::asset('resources/common/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('resources/common/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('resources/common/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{URL::asset('resources/common/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('resources/common/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('resources/common/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{URL::asset('resources/common/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{URL::asset('resources/common/assets/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Sailor - v4.7.0
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
  .text-red{
    color: red;
  }
  .align-class {
    display: flex;
    justify-content: center
  }

  .d-c-btn{
    display: flex;
    justify-content: center;
  }
  .ls-ls {
    padding-left: 13px;
  }
  a .a-tag{
    padding-left: 200px;
    color: #288851;
  }
  .offset-2{
    margin-left: 3rem;
  }
  .deactive-info h3{
    font-family: Roboto,Arial,sans-serif;
    font-size: 20px;
  }
  .ls-ls li{
    font-family: Roboto,Arial,sans-serif;
    padding-top: 10px;
    font-size: 15px;
  }
  .deactive-info p{
    font-family: Roboto,Arial,sans-serif;
    font-size: 15px;
  }
  .ln-0{
    padding-top: 10px;
  }
  .btn-col{
    background-color: #288851;
    color: #fff;
    border: none;
    padding: 10px;
    width: 100%;
    font-family: Roboto,Arial,sans-serif;
    font-weight: 400;
  }
  .d-c-btn a{
    color: #288851;
    font-weight: 700;
    font-family: Roboto,Arial,sans-serif;
  }
  .deactive-info h2{
    font-family: Roboto,Arial,sans-serif;
    font-size: 20px;
    font-weight: 750;
  }
  .deactive-info h4{
    font-family: Roboto,Arial,sans-serif;
    font-size: 26px;
    font-weight: 750;
  }
  </style>
</head>

<body>
  <main id="main" class="inner-page">
    <section id="about" class="about" style="margin-top:100px;">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="deactive-info">
              <h2>When you deactivate your account</h2>
            </div>
            <div>
              <ul class="ls-ls">
                <li>You are logged out of your {{ config('app.name') }} Account</li>
                <li>Your public profile on {{ config('app.name') }} is no longer visible</li>
                <li>Your reviews/ratings are still visible, while your profile information is
                  shown as ‘unavailable’ as a result of deactivation.
                </li>
                <li>Your wishlist items are no longer accessible through the associated public
                  hyperlink. Wishlist is shown as ‘unavailable’ as a result of deactivation
                </li>
                <li>You will be unsubscribed from receiving promotional emails from {{ config('app.name') }}
                </li>
                <li>Your account data is retained and is restored in case you choose to
                  reactivate your account
                </li>
              </ul>
            </div>
            <div class="deactive-info">
              <h2>How do I reactivate my {{ config('app.name') }} account?
              </h2>
              <p class="ln-0">Reactivation is easy.
              </p>
              <p class="ln-0">Simply login with your registered email id or mobile number and password
                combination used prior to deactivation. Your account data is fully restored.
                Default settings are applied and you will be subscribed to receive promotional
                emails from {{ config('app.name') }}.</p>
                <p class="ln-0">{{ config('app.name') }} retains your account data for you to conveniently start off from where
                  you
                  left, if you decide to reactivate your account.
                </p>
                <p class="ln-0">Remember: Account Reactivation can be done on the Desktop version only.</p>
              </div>
            </div>
            <div class="col-md-4 offset-2">
              <div class="deactive-info mt-font">
                <h4>Are you sure you want to leave?</h4>
              </div>
              <br>
              @if(session()->has('message'))
              <div class="alert alert-success">
                {{ session()->get('message') }}
              </div>
              @endif
              <form action="{{url('/deactivate-account')}}" method="POST" id="deActivateAccountForm">
                @csrf
                <div class="form-row">
                  <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Enter Your Email">
                    @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="form-group" style="margin-top:10px;">
                    <input type="number" class="form-control" name="phone" placeholder=" Enter Your Phone">
                    @if ($errors->has('phone'))
                    <span class="help-block">
                      <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="form-group" style="margin-top:10px;">
                  <input type="password" class="form-control" name="password" placeholder="Enter Your Password">
                  @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="d-c-btn" style="margin-top:10px;">
                  <button type="submit" class="btn-col col-12" id="submitForm">CONFIRM DEACTIVATION</button>

                </div>
                <br>
                <!-- <div class="col-12 d-c-btn">
                <a class="a-tag" href="#">NO, LET ME STAY!</a>
              </div> -->
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js') }}"></script>
  <script src="{{ URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js') }}"></script>
  <script>
  $.validator.addMethod("email", function(value, element) {
    return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    .test(value);
  }, "Please enter valid email.");

  $.validator.addMethod("password", function(value, element) {
    return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value);
  }, "Please enter valid password.");

  $(document.body).on('click', "#submitForm", function() {
    if ($("#deActivateAccountForm").length) {
      $("#deActivateAccountForm").validate({
        errorElement: 'span',
        errorClass: 'text-left d-block required mt-1 text-red',
        ignore: [],
        rules: {
          "phone-01": {
            required:true,
            number: true,
            minlength: 6,
            maxlength: 14
          }
        },
        messages: {
          "phone": {
            remote: "This phone number is already registered with us.",
            required:"Phone field is required"
          }
        },
        errorPlacement: function(error, element) {
          if (element.attr("name") == "phone") {
            $('.iti__selected-flag').css('height', '66%');
          }
          if (element.is('select')) {
            error.appendTo(element.closest("div"));
          } else {
            error.insertAfter(element.closest(".form-control"));
          }

        },
        submitHandler: function(form, e) {
          e.preventDefault();
          $("#submitForm").html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
          form.submit();
        },
      });
    }
  });
  </script>
</body>
<html>
