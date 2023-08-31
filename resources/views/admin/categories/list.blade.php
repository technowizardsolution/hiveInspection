@section('title')
  Categories |
@endsection
@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
  {{--  add new modal  --}}
  <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  " role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title" id="myModalLabel">New Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="CategoryForm" role="form" action="{{url('admin/categories')}}" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              <label  class="col-sm-4 control-label" for="name">Name <span class="colorRed"> *</span></label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{old('name')}}"/>
                @if ($errors->has('name'))
                  <span class="help-block alert alert-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" id="createBtn" class="btn btn-info pull-right">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Content Header (Page header) -->
  <div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Categories</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Categories
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
                      {{-- <a href="{{route('categories.create')}}" class="float-right">
                        <button type="button" class="btn btn-primary waves-effect waves-float waves-light">New Category</button>
                      </a> --}}
                      <div class="col-sm-2 pull-right" style="padding-bottom: 10px;">
                        @can('categories-create')
                            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">New Category</button>
                        @endcan
                      </div>
                  </div>
                   <div class="clear-fix"></div>
                  <div class="col-12">
                      <div class="card">
                          <div class="card-header border-bottom">
                              <h4 class="card-title">Categories</h4>
                          </div>
                          <div class="card-datatable datatable-row-remove">
                              {!! $html->table(['class' => 'table  dt-complex-header table-bordered','id'=>'UserDataTable']) !!}
                          </div>
                      </div>
                  </div>
                </div>
            </section>
        </div>
    </div>
</div>
  <!-- /.content -->
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
  {!! $html->scripts() !!}


<script>
  $(document).ajaxStart(function() { Pace.restart(); });
  var today = new Date();
  $('#dob').datepicker({
    format: 'dd-MM-yyyy',
    autoclose:true,
    endDate: "today",
    maxDate: today
  });
  var SITE_URL = "<?php echo URL::to('/'); ?>";

  $(document.body).on('click', "#createBtn", function(){
    if ($("#CategoryForm").length){
      $("#CategoryForm").validate({
        errorElement: 'span',
        errorClass: 'text-red text-danger',
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
  $(document.body).on('click', '.actStatus' ,function(event){
    var row = this.id;
    var dbid = $(this).attr('data-sid');

    bootbox.confirm({
      message: "Are you sure you want to change Category status ?",
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
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type :'POST',
            data : {id:dbid},
            url  : SITE_URL+'/admin/categories/status-change',
            success  : function(response) {
              if (response == 'Active') {
                $('#'+row+'').text('Active').removeClass('text-danger').addClass('text-green');
            }
            else if(response == 'Deactive') {
                $('#'+row+'').text('Deactive').removeClass('text-green').addClass('text-danger');
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

  function deleteConfirm(id){
    bootbox.confirm({
      message: "Are you sure you want to delete ?",
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
            url: SITE_URL + '/admin/categories/delete/'+id,
            success: function (data) {
              toastr.warning('Category Deleted !!');
              $('#categoryDataTable').DataTable().ajax.reload(null, false);
            }
          });
        }
      }
    })
  }

  $(document.body).on('change', "#state", function(){
    var id = $('#state').val();
    if (id != '') {
      $.ajax({
        url: SITE_URL + '/getCity/'+id,
        success: function (data) {
          if (data != '') {
            $('select[name="city"]').empty();
            $('select[name="city"]').append('<option value="">Please select</option>');
            $.each(data, function (i) {
              $('select[name="city"]').append('<option value="' + data[i].cityId + '">' + data[i].cityName + '</option>');
            });

          } else {
            $('select[name="city"]').empty();
            $('select[name="city"]').append('<option value="">Please select</option>');
          }
        }
      });
    } else {
      $('select[name="city"]').empty();
      $('select[name="city"]').append('<option value="">Please select</option>');
    }

  });
</script>
@endsection

