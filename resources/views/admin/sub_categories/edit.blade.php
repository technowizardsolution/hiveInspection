@section('title')
Categories |
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
                        <h2 class="content-header-title float-left mb-0">Update User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Update User
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
                                <h4 class="card-title">Update User</h4>
                            </div>
                            <div class="card-body">
                                <form class="" id="SubCategoryForm" role="form" action="{{url('admin/sub-categories')}}/{{$sub_category->sub_category_id}}" method="post" enctype="multipart/form-data" >
                {{method_field('PUT')}}
                {{ csrf_field() }}
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Categorie Detail</h3>
                            {{-- <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div> --}}
                        </div>
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <label  class=" control-label" for="category_id">Category <span class="colorRed"> *</span></label>
                                <div>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}" @if($category->category_id == $sub_category->category_id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('category_id'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label  class=" control-label" for="name">Name <span class="colorRed"> *</span></label>
                                <div class="jointbox">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="@if($sub_category->name) {{$sub_category->name}} @else {{old('name')}} @endif"/>
                                    @if ($errors->has('name'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="col-sm-12">
                                <div class="" style="border-top:0">
                                    <div class="box-footer">
                                        <button type="submit" id="submitBtn" class="btn btn-primary pull-right" style="margin-left: 20px;">Submit</button>
                                        <button type="button" id="cancelBtn" class="btn btn-info pull-right">Cancel</button>
                                    </div>
                                </div>
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
    .alert{
        padding: 6px !important;
    }
    .actStatus{
        cursor: pointer;
    }
</style>
@endsection
@section('script')

<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js')}}"></script>
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
        $('#myModal').modal('show');
        });
    </script>
@endif

<script>
    $(document).ajaxStart(function() { Pace.restart(); });
    $("#cancelBtn").click(function () {
        window.location.href = "{{url('admin/sub-categories')}}";
    });
    var SITE_URL = "<?php echo URL::to('/'); ?>";

    $(document).ready(function() {
        $("#category_id").select2({
            placeholder: "Select a Category",
            allowClear: true,
        });
    });

    $(document.body).on('click', "#submitBtn", function(){
        if ($("#SubCategoryForm").length){
            $("#SubCategoryForm").validate({
            errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                      "name":{
                          required:true,
                          minlength: 2,
                          maxlength: 20
                      },
                      "category_id":{
                          required:true,
                      }
                  },
                  messages: {
                      "name":{
                          required:"Please enter SubCategory Name.",
                      },
                      "category_id":{
                          required:"Please select Category.",
                      }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'category_id'){
                            error.insertAfter(element.closest("div"));
                        }else{
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
            });
        }
    });
</script>
@endsection

