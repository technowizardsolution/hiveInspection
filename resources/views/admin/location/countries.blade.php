
@section('title')
Country |
@endsection 
@extends('admin.layouts.app')

@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Country</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Country
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="">
                <div class="row">
                    <div class="col-sm-12 pull-right  " style="padding-bottom: 10px;">
                        <div class="float-right">
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-toggle="modal" data-target="#countryModal">New Country</button>
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-toggle="modal" data-target="#stateModal">New State</button>
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-toggle="modal" data-target="#cityModal">New City</button>
                        </div>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Country</h4>
                            </div>
                            <div class="card-datatable datatable-row-remove">
                                {!! $html->table(['class' => 'table dt-complex-header table-bordered ','id'=>'DataTable']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
{{--  add new modal for country --}}
<div class="modal fade in" id="countryModal" role="dialog" aria-labelledby="countryModalLabel">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">New Country</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="countryForm" role="form" action="{{url('admin/countries')}}" method="post" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('short_code') ? ' has-error' : '' }}">
                        <label  class=" control-label" for="short_code">Short Code <span class="colorRed"> *</span></label>
                        <div class=" jointbox">
                            <input type="type" class="form-control" name="short_code" maxlength="2" placeholder="Short Code" value="{{old('short_code')}}"/>
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
                            <input type="type" class="form-control" name="country_name" placeholder="Country Name" value="{{old('country_name')}}"/>
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
                            <input type="number" class="form-control" placeholder="Phonecode" name="phonecode" max="500000" value="{{old('phonecode')}}"/>
                            @if ($errors->has('phonecode'))
                            <span class="help-block alert alert-danger">
                                <strong>{{ $errors->first('phonecode') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                        <button type="submit" id="countryCreateBtn" class="btn btn-primary pull-right">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--  add new modal for state--}}
<div class="modal fade in " id="stateModal" role="dialog" aria-labelledby="stateModalLabel">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="stateModalLabel">New State</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="stateForm" role="form" action="{{url('admin/state/new')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('state_country') ? ' has-error' : '' }}">
                        <label  class=" control-label" for="state_country">Country <span class="colorRed"> *</span></label>
                        <div class="">
                            <select name="state_country" id="state_country" class="form-control">
                                <option></option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                @endforeach
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
                        <label  class=" control-label" for="state_name">State Name <span class="colorRed"> *</span></label>
                        <div class="">
                            <input type="text" class="form-control" id="state_name" name="state_name" placeholder="State Name" value="{{old('state_name')}}"/>
                            @if ($errors->has('state_name'))
                            <span class="help-block alert alert-danger">
                                <strong>{{ $errors->first('state_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                        <button type="submit" id="stateCreateBtn" class="btn btn-primary pull-right">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 {{--  add new modal for city  --}}
 <div class="modal fade in" id="cityModal" role="dialog" aria-labelledby="cityModalLabel">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cityModalLabel">New City</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="cityForm" role="form" action="{{url('admin/city/new')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('city_country') ? ' has-error' : '' }}">
                        <label  class=" control-label" for="city_country">Country <span class="colorRed"> *</span></label>
                        <div class="">
                            <select name="city_country" id="city_country" class="form-control">
                                <option></option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <div class="country-error"></div>
                            @if ($errors->has('city_country'))
                            <span class="help-block alert alert-danger">
                                <strong>{{ $errors->first('city_country') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('city_state') ? ' has-error' : '' }}">
                        <label  class=" control-label" for="city_state">State <span class="colorRed"> *</span></label>
                        <div class="">
                            <select name="city_state" id="city_state" class="form-control">
                            </select>
                            <div class="state-error"></div>
                            @if ($errors->has('city_state'))
                            <span class="help-block alert alert-danger">
                                <strong>{{ $errors->first('city_state') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('city_name') ? ' has-error' : '' }}">
                        <label  class=" control-label" for="city_name">City <span class="colorRed"> *</span></label>
                        <div class="">
                            <input type="text" class="form-control" id="city_name" name="city_name" placeholder="City Name" value="{{old('city_name')}}"/>
                            @if ($errors->has('city_name'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('city_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                        <button type="submit" id="cityCreateBtn" class="btn btn-primary pull-right">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
   
@endsection
@section('css')
    <style>
        .alert{
            padding: 6px !important;
        }
        .actStatus{
            cursor: pointer;
        }
        .form-group .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('script')
{!! $html->scripts() !!}
    <script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
    @if(Session::has('message'))
        <script>
            $(function() {
                toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
            });
        </script>
    @endif

    @if(Session::has('errors'))
        <script>
            $(function() {
                @if($errors->has('short_code') || $errors->has('country_name') || $errors->has('phonecode'))
                    $('#countryModal').modal('show');
                @elseif ($errors->has('state_country') || $errors->has('state_name'))
                    $('#stateModal').modal('show');
                @elseif ($errors->has('city_country') || $errors->has('city_name') || $errors->has('city_state'))
                    $('#cityModal').modal('show');
                @endif
            });
        </script>
    @endif

    <script>
        // $(document).ajaxStart(function() { Pace.restart(); });

        var SITE_URL = "<?php echo URL::to('/'); ?>";

        $(document).ready(function() {
            $("#state_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });

            $("#city_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });

            $("#city_state").select2({
                placeholder: "Select a State",
                allowClear: true,
            });
        });

        $('#city_country').on('change', function(){

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


        $(document.body).on('click', "#countryCreateBtn", function(){
            if ($("#countryForm").length){
                $("#countryForm").validate({
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
                            required:"Enter Short code",
                        },
                        "country_name":{
                            required:"Enter Country Name",
                        },
                        "phonecode":{
                            required:"Enter Phonecode",
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                });
            }
        });

        $(document.body).on('click', "#stateCreateBtn", function(){
            if ($("#stateForm").length){
                $("#stateForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {
                        "state_country":{
                            required:true,
                        },
                        "state_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        }
                    },
                    messages: {
                        "state_country":{
                            required:"Select country",
                        },
                        "state_name":{
                            required:"Enter State name",
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'state_country'){
                            element.closest('.form-group ').find(".country-error").html(error);
                        } else {
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
                });
            }
        });

        $(document.body).on('click', "#cityCreateBtn", function(){
            if ($("#cityForm").length){
                $("#cityForm").validate({
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

        function deleteConfirm(id){
            bootbox.confirm({
            message: "<p class='text-red'>Are you sure you want to delete ?</p><p class='text-red'>It will delete all the related states and cities.</p>",
                buttons: {
                    'cancel': {
                        label: 'No',
                        className: 'btn-danger'
                    },
                    'confirm': {
                        label: 'Yes',
                        className: 'btn-success'
                    }
                },
                callback: function(result){
                    if (result){
                        $.ajax({
                            url: SITE_URL + '/admin/country/delete/'+id,
                            success: function (data) {
                                toastr.warning('Country Deleted !!');
                                $('#datatable').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                }
            })
        }

        $(document.body).on('click', '.actStatus' ,function(event){
            var row = this.id;
            var dbid = $(this).attr('data-sid');
            bootbox.confirm({
            message: "Are you sure you want to change status ?",
            buttons: {'cancel': { label: 'No',className: 'btn-danger'},
            'confirm': { label: 'Yes',className: 'btn-success'}
            },
            callback: function(result){  
            if (result){
                $.ajax({
                type :'POST',
                data : {id:dbid, _token:'{{ csrf_token() }}'},
                url  : SITE_URL+'/admin/countries/status-change',
                success  : function(response) {
                    if (response == 'Active') {
                        $('#'+row+'').text('Active').removeClass('text-danger').addClass('text-success');
                    }
                    else if(response == 'Deactive') {
                        $('#'+row+'').text('Deactive').removeClass('text-success').addClass('text-danger');
                    }
                    else if(response == 'error') {
                    bootbox.alert('Something Went to Wrong');
                    }
                }
                });
                }
            }
            });
        });

    </script>
@endsection
