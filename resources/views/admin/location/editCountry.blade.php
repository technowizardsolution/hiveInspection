@section('title')
Country Detail |
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/resources/assets/admin/plugins/lightbox2-master/dist/css/lightbox.css')}}">
@endsection
@extends('admin.layouts.app') @section('content')


<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Update Country</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item "><a href="{{url('admin/countries')}}">Country</a>
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
                                <h4 class="card-title">Update Country</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" id="editCountryForm" action="{{url('admin/countries/'.$country->country_id)}}" method="post" enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('short_code') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="short_code">Short Code <span class="colorRed"> *</span></label>
                                                <div class=" jointbox">
                                                    <input type="type" class="form-control" name="short_code" maxlength="2" placeholder="Short Code" value="@if(!empty(old('short_code'))){{old('short_code')}}@else{{$country->sortname}}@endif"/>
                                                    @if ($errors->has('short_code'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('short_code') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('country_name') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="country_name" >Country Name <span class="colorRed"> *</span></label>
                                                <div class=" jointbox">
                                                    <input type="type" class="form-control" name="country_name" placeholder="Country Name" value="@if(!empty(old('country_name'))){{old('country_name')}}@else{{$country->name}}@endif"/>
                                                    @if ($errors->has('country_name'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('country_name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('phonecode') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="phonecode">Phonecode<span class="colorRed"> *</span></label>
                                                <div class=" jointbox">
                                                    <input type="number" class="form-control" placeholder="Phonecode" name="phonecode" max="500000" value="@if(!empty(old('phonecode'))){{old('phonecode')}}@else{{$country->phonecode}}@endif"/>
                                                    @if ($errors->has('phonecode'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('phonecode') }}</strong>
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
                                                    <button type="submit" id="updateCountryBtn" class="btn btn-primary pull-right" style="margin-left: 20px;float:right;">Update</button>
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
            window.location.href = "{{url('admin/countries')}}";
        });

        $(document.body).on('click', "#updateCountryBtn", function(){

            if ($("#editCountryForm").length){
                $("#editCountryForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {
                        "short_code":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                        "country_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                        "phonecode":{
                            required:true,
                            number:true,
                            min:1,
                            minlength:1,
                            maxlength:5
                        },
                    },
                    messages: {
                        "short_code":{
                            required:"Please enter short code",
                        },
                        "country_name":{
                            required:"Please enter country name",
                        },
                        "phonecode":{
                            required:"Please enter phoneCode",
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                });
            }
        });

        var today = new Date();

        $('#dob').datepicker({
            format: 'yyyy-mm-dd',
            autoclose:true,
            endDate: "today",
            maxDate: today
        });

        var SITE_URL = "<?php echo URL::to('/'); ?>";

        function readURL(input) {
            var old_profile_image = $('#old_profile_image').val();
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.old_profile_imageSub')
                        .attr('src', e.target.result)
                        .width(125)
                        .height(125);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#country').on('change', function(){
            $('#state').html('');
            $('#city').html('');
            var id = $('#country').val();
            var state = {{ !empty($country->state) ? $country->state: 'null' }};
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITE_URL+'/getState',
                data: {
                    id,
                    state
                },
                success: function(data) {
                    $('#state').html(data);
                }
            });
        });

        $('#state').on('change', function(){
            $('#city').html('');
            var id = $('#state').val();
            var city = {{ (!empty($country->city)) ? $country->city: 'null' }};
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITE_URL+'/getCity',
                data: {
                    id,
                    city
                },
                success: function(data) {
                    $('#city').html(data);
                }
            });
        });
    </script>
@endsection
