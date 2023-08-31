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
                        <h2 class="content-header-title float-left mb-0">Update category</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Update category
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
                                <h4 class="card-title">Update category</h4>
                            </div>
                            <div class="card-body">
                                <form class="" id="dataForm" role="form" action="{{url('admin/categories')}}/{{$category->category_id}}" method="post" enctype="multipart/form-data" >
                                    {{method_field('PUT')}}
                                    {{ csrf_field() }}
                                    <div class="col-sm-12">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                {{-- <h3 class="box-title">Categorie Detail</h3> --}}
                                                {{-- <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div> --}}
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label  class=" control-label" for="name">Name <span class="colorRed"> *</span></label>
                                                    <div class=" jointbox">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="@if($category->name) {{$category->name}} @else {{old('name')}} @endif"/>
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
$("#cancelBtn").click(function () {
    window.location.href = "{{url('admin/categories')}}";
});
    $(document).ajaxStart(function() { Pace.restart(); });

    var SITE_URL = "<?php echo URL::to('/'); ?>";

    $(document.body).on('click', "#submitBtn", function(){
        if ($("#dataForm").length){
            $("#dataForm").validate({
            errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                      "name":{
                          required:true,
                          minlength: 2,
                          maxlength: 20
                      },
                  },
                  messages: {
                      "name":{
                          required:"Please enter Category Name.",
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

