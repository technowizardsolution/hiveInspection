
@extends('admin.layouts.app')
@section('title') Update Hive | @endsection

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Update Hive</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Update Hive
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
                                <h4 class="card-title">Update Hive</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" id="hiveForm" action="{{url('admin/hive').'/'.$hivedata->hive_id}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group {{ $errors->has('user') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="user">User <span class="colorRed"> *</span></label>                                            
                                                <select name="user_id" id="user_id" class="form-control" disabled>
                                                    <option></option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->user_id }}" @if($user->id == $hivedata->user_id) selected @endif>{{ $user->email }}</option>
                                                    @endforeach
                                                </select>                                            
                                                @if ($errors->has('user_id'))
                                                <span class="help-block alert alert-danger">
                                                    <strong>{{ $errors->first('user_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group {{ $errors->has('hive_name') ? ' has-error' : '' }}">
                                                <label for="hive_name">Hive Name</label>
                                                <input type="text" class="form-control" name="hive_name" id="hive_name" value="@if(isset($hivedata) && $hivedata->hive_name){{$hivedata->hive_name}}@endif" placeholder="Hive Name">
                                                @if ($errors->has('hive_name'))
                                                <span class="help-block alert alert-danger">
                                                    <strong>{{ $errors->first('hive_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Location</label>
                                                <input type="text" class="form-control" name="location" id="location" value="@if(isset($hivedata) && $hivedata->location){{$hivedata->location}}@endif" placeholder="Location">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Build Date</label>
                                                <input type="date" class="form-control" name="build_date" id="build_date" value="@if(isset($hivedata) && $hivedata->build_date){{$hivedata->build_date}}@endif" placeholder="Build Date">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Origin</label>
                                                <input type="text" class="form-control" name="origin" id="origin" value="@if(isset($hivedata) && $hivedata->origin){{$hivedata->origin}}@endif" placeholder="Origin">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Deeps</label>
                                                <input type="number" class="form-control" name="deeps" id="deeps" value="@if(isset($hivedata) && $hivedata->deeps){{$hivedata->deeps}}@endif" placeholder="Deeps">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Mediums</label>
                                                <input type="number" class="form-control" name="mediums" id="mediums" value="@if(isset($hivedata) && $hivedata->mediums){{$hivedata->mediums}}@endif" placeholder="Mediums">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Queen Introduced</label>
                                                <input type="date" class="form-control" name="queen_introduced" id="queen_introduced" value="@if(isset($hivedata) && $hivedata->queen_introduced){{$hivedata->queen_introduced}}@endif" placeholder="Queen Introduced">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="" style="border-top:0">
                                                <div class="box-footer">
                                                    <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                                                    <button type="submit" id="updateBtn" class="btn btn-primary pull-right" style="margin-left: 20px;float:right;">Update</button>
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
@section('script')
@if(Session::has('message'))
    <script>
        $(function() {
        toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
    </script>
@endif
<script>
    $("#cancelBtn").click(function () {
        window.location.href = "{{url('admin/hive')}}";
    });
    $(document).ajaxStart(function() { Pace.restart(); });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });  
    $(document.body).on('click', "#hiveForm", function(){
            if ($("#hiveForm").length){
                $("#hiveForm").validate({
                errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {                      
                            "hive_name":{
                                required:true
                            },
                            "location":{
                                required:true
                            },
                            "build_date":{
                                required:true,                            
                            },
                            "origin":{
                                required:true,                            
                            },
                            "deeps":{
                                required:true,                            
                            },
                            "mediums":{
                                required:true,                            
                            },
                            "queen_introduced":{
                                required:true,                            
                            }

                    },
                    messages: {
                        "hive_name":{
                            required:"Please enter hive name.",
                        },
                        "location":{
                            required:"Please enter location.",
                        },
                        "build_date":{
                            required:"Please enter build date.",                            
                        },
                        "origin":{
                            required:"Please enter origin.",                            
                        },
                        "deeps":{
                            required:"Please enter deeps.",                            
                        },
                        "mediums":{
                            required:"Please enter mediums.",                            
                        },
                        "queen_introduced":{
                            required:"Please enter queen introduced.",                            
                        }       
                    },
                    errorPlacement: function(error, element) {
                        if(element.is('select')){
                            error.appendTo(element.closest("div"));
                        }else{
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
                });
            }
        }); 

        $(document).ready(function() {
            $("#user_id").select2({
                placeholder: "Select a User",
                allowClear: true,
            });
        });
</script>

@endsection
