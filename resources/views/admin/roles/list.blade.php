@section('title') Role | @endsection
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
                        <h2 class="content-header-title float-left mb-0">Roles</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Roles
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
                    @can('role-create')
                      <a href="{{route('roles.create')}}" class="float-right">
                        <button type="button" class="btn btn-primary waves-effect waves-float waves-light">New Role</button>
                      </a>
                    @endcan
                  </div>
                   <div class="clear-fix"></div>
                  <div class="col-12">
                      <div class="card">
                          <div class="card-header border-bottom">
                              <h4 class="card-title">Roles</h4>
                          </div>
                          <div class="card-datatable datatable-row-remove">
                              {!! $html->table(['class' => 'table  dt-complex-header table-bordered','id'=>'DataTable']) !!}
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
{!! $html->scripts() !!}
@if(Session::has('message'))
    <script>
    $(function() {
      toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
    });
    </script>
@endif

  <script>
    var SITE_URL = "<?php echo URL::to('/'); ?>";

    function deleteConfirm(id){
        if(id==1){
        bootbox.alert("You can't delete admin role");
        }
        else{
            bootbox.confirm({
                message: "Are you sure you want to delete ?",
                buttons: {
                    'cancel': {label: 'No',className: 'btn-danger'},
                    'confirm': {label: 'Yes',className: 'btn-success'}
                },
                callback: function(result){
                    if (result){
                        $.ajax({
                            url: SITE_URL + '/admin/roles/'+id,
                            type: "DELETE",
                            cache: false,
                            data:{ _token:'{{ csrf_token() }}'},
                            success: function (data, textStatus, xhr) {
                            if(data== true && textStatus=='success' && xhr.status=='200')
                                {
                                    toastr.warning('Role Deleted !!');
                                    $('#DataTable').DataTable().ajax.reload(null, false);
                                }else {
                                    toastr.error(data);
                                }
                            }
                        });
                    }
                }
            });
        }
    }
</script>
@endsection
