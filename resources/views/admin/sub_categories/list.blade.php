@section('title')
  Categories |
@endsection
@extends('admin.layouts.app')
@section('content')
  <div class="content-wrapper">
    {{--  add new modal  --}}
    <div class="modal fade in" id="myModal" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">New SubCategory</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>

          <div class="modal-body">
            <form class="form-horizontal" id="SubCategoryForm" role="form" action="{{url('admin/sub-categories')}}" method="post" enctype="multipart/form-data" >
              {{ csrf_field() }}
              <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                <label  class="col-sm-4 control-label" for="category_id">Category <span class="colorRed"> *</span></label>
                <div class="col-sm-8">
                  <div>
                    <select name="category_id" id="category_id" class="form-control">
                      <option></option>
                      @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  @if ($errors->has('category_id'))
                    <span class="help-block alert alert-danger">
                      <strong>{{ $errors->first('category_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

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
                          <h2 class="content-header-title float-left mb-0">Sub Category</h2>
                          <div class="breadcrumb-wrapper">
                              <ol class="breadcrumb">
                                  <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                  </li>
                                  <li class="breadcrumb-item active">Sub Category
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
                        {{-- <a href="{{route('roleuser.create')}}" class="float-right">
                          <button type="button" class="btn btn-primary waves-effect waves-float waves-light">New Sub Category</button>
                        </a> --}}
                        <div class="col-sm-2 pull-right" style="padding-bottom: 10px;">
                          <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">New Sub Category</button>
                        </div>
                    </div>
                     <div class="clear-fix"></div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Sub Category</h4>
                            </div>
                            <div class="card-datatable datatable-row-remove">
                                {!! $html->table(['class' => 'table  dt-complex-header table-bordered','id'=>'RoleUserDataTable']) !!}
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
  $(document).ready(function() {
    $("#category_id").select2({
      placeholder: "Select a Category",
      allowClear: true,
    });
  });
  var SITE_URL = "<?php echo URL::to('/'); ?>";

  $(document.body).on('click', "#createBtn", function(){
    if ($("#SubCategoryForm").length){
      $("#SubCategoryForm").validate({
        errorElement: 'span',
        errorClass: 'text-red text-danger',
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
            url  : 'categories/status-change',
            success  : function(response) {

              if (response == 'Active') {
                $('#'+row+'').text('Active');
                $('#'+row+'').removeClass('text-danger');
                $('#'+row+'').addClass('text-green');
              }
              else if(response == 'Deactive') {
                $('#'+row+'').text('Deactive');
                $('#'+row+'').removeClass('text-green');
                $('#'+row+'').addClass('text-danger');
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
            url: SITE_URL + '/admin/sub-categories/delete/'+id,
            success: function (data) {
              toastr.warning('SubCategory Deleted !!');
              $('#subCategoryDataTable').DataTable().ajax.reload(null, false);
            }
          });
        }
      }
    })
  }
</script>
@endsection