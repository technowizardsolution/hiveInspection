@extends('layouts.authapp')
@section('content')
<style type="text/css">
    body{
        background-color: #f3f8f6!important;
    }
</style>
<div class="app-content content ">
<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper">
  <div class="content-body">
      <div class="auth-wrapper auth-v2">
          <div class="auth-inner row m-0">
              <a class="brand-logo" href="{{url('/')}}">
                  <img src="{{ URL::asset('resources/uploads/Logo.png')}}" alt="" height="80">
                  <!-- <h2 class="brand-text text-primary ml-1">{{ config('app.name', 'Laravel') }}</h2> -->
              </a>
              <div class="d-none d-lg-flex col-lg-12 align-items-center p-5">
                  <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><h1><strong>Thank you for booking. We will be in touch with you soon.</strong></h1></div>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
@endsection
