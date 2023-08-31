
@extends('admin.layouts.app') 
@section('title')
City Detail |
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/resources/assets/admin/plugins/lightbox2-master/dist/css/lightbox.css')}}">
@endsection
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Update City</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item "><a href="{{url('admin/countries')}}">Country</a>
                                </li>
                                <li class="breadcrumb-item "><a href="{{url('admin/countries').'/'.$state->country_id}}">State</a>
                                </li>
                                <li class="breadcrumb-item "><a href="{{url('admin/state').'/'.$city->state_id}}">City</a>
                                </li>
                                <li class="breadcrumb-item active">Detail
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
                                <h4 class="card-title">Update City</h4>
                            </div>
                            <div class="card-body">
                                <form class="" id="editCityForm" action="{{route('updateCity')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="hidden" name="city_id" value="{{$city->city_id}}">
                                            <div class="form-group {{ $errors->has('state_country') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="state_country">Country <span class="colorRed"> *</span></label>
                                                <div class="">
                                                <select id="state_country" class="form-control" name="state_country" disabled >
                                                            <option value="{{ $countries->country_id }}" selected>{{ $countries->name }}</option>
                                                    </select>
                                                    <div class="country-error"></div>
                                                    @if ($errors->has('state_country'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('state_country') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('state_name') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="state_name">State <span class="colorRed"> *</span></label>
                                                <div class="">
                                                <select id="state_name" class="form-control" name="state_name" disabled >
                                                        <option value="{{ $state->country_id }}" selected>{{ $state->name }}</option>
                                                    </select>
                                                    <div class="country-error"></div>
                                                    @if ($errors->has('state_name'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('state_name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('city_name') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="city_name">City Name <span class="colorRed"> *</span></label>
                                                <div class="">
                                                    <input type="text" class="form-control" id="city_name" name="city_name" placeholder="State Name" value="{{ $city->name}}"/>
                                                    @if ($errors->has('city_name'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('city_name') }}</strong>
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
                                                    <button type="submit" id="updateCityBtn" class="btn btn-primary pull-right" style="margin-left: 20px;float:right;">Update</button>
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

@section('css')
    <style>
        .form-group .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('script')
    @if(Session::has('message'))
        <script>
            $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
            });
        </script>
    @endif

    <script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js')}}"></script>
    <script>
        $("#cancelBtn").click(function () {
            window.location.href = "{{url('admin/state/'.$state->state_id)}}";
        });
         $(document).ready(function() {
           $("#city_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });

            $("#city_state").select2({
                placeholder: "Select a State",
                allowClear: true,
            });
        });
        $(document.body).on('click', "#updateCityBtn", function(){

            if ($("#editCityForm").length){
                $("#editCityForm").validate({
        
                    errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {
                        "city_country":{
                            required:true,
                        },
                        "city_state":{
                            required:true,
                        },
                        "city_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        }
                    },
                    messages: {
                        "city_country":{
                            required:"Select Country",
                        },
                        "city_state":{
                            required:"Select state",
                        },
                        "city_name":{
                            required:"Enter City name",
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'city_country'){
                            element.closest('.form-group ').find(".country-error").html(error);
                        } else if(element.attr("name") == 'city_state'){
                            element.closest('.form-group ').find(".state-error").html(error);
                        } else {
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
                });
            }
        });

 $('#city_country').on('change', function(){
        var SITE_URL = "<?php echo URL::to('/'); ?>";

            var id = $('#city_country').val();
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITE_URL+'/getState',
                data: {
                    id
                },
                success: function(data) {
                    $('#city_state').html(data);
                }
            });
        });

    </script>
@endsection
