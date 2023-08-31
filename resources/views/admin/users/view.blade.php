@extends('admin.layouts.app')
@section('title')  User Details | @endsection
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">User Details</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">User Details
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
                                <h4 class="card-title">User Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-user-information">
                                      <tbody>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td class="text-primary">{{$user->first_name}}</td>
                                        </tr>
                                          <tr>
                                            <td><strong>Email</strong></td>
                                            <td class="text-primary">{{$user->email}}</td>
                                        </tr>
                                          <tr>
                                            <td><strong>Phone Number</strong></td>
                                            <td class="text-primary">{{$user->mobile_number}}</td>
                                        </tr>

                                          <tr>
                                            <td><strong>Date of Birth</strong></td>
                                            <td class="text-primary">{{$user->dob}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gender</strong></td>
                                            <td class="text-primary">
                                              @if($user->gender == 'm')
                                                Male
                                              @elseif($user->gender == 'f')
                                                Female
                                              @endif
                                            </td>
                                        </tr>

                                        <tr>
                                          <td><strong>Country</strong></td>
                                          <td class="text-primary">@if(isset($user->countyData)){{$user->countyData->name}}@else @endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>State</strong></td>
                                            <td class="text-primary">@if(isset($user->stateData)){{$user->stateData->name}}@else @endif</td>
                                        </tr>
                                          <tr>
                                            <td><strong>City</strong></td>
                                            <td class="text-primary">@if(isset($user->cityData)){{$user->cityData->name}}@else @endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Profile Image</strong></td>
                                            <td class="text-primary">
                                              <figure>
                                                <img src="@if(isset($user))@if($user->getOriginal('profile_picture')){{$user->profile_picture}} @endif @else {{ URL::asset('/resources/assets/img/user.png')}} @endif " class="gambar old_profile_imageSub" id="item-img-output"  name="avatar" width="300px"/>
                                              </figure>
                                            </td>
                                          </tr>

                                          <tr>
                                            <td><strong>Detected Image</strong></td>
                                            <td class="text-primary">
                                              <figure>
                                                <img src="@if(isset($user))@if($user->getOriginal('detected_photo')){{$user->detected_photo}} @endif @else {{ URL::asset('/resources/assets/img/user.png')}} @endif " class="gambar old_profile_imageSub" id="item-img-output"  name="avatar" width="300px"/>
                                              </figure>
                                            </td>
                                          </tr>
                                      </tbody>
                                    </table>
                                    <div class="col-sm-12">
                                        <div class="" style="border-top:0">
                                            <div class="box-footer">
                                                <a type="" href="{{url('/admin/users')}}" id="cancelBtn" class="btn btn-primary pull-right">
                                                  Back
                                                </a>
                                            </div>
                                        </div>
                                    </div>
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
