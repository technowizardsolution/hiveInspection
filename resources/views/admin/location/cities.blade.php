@extends('admin.layouts.app')

@section('title')
City |
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
                        <h2 class="content-header-title float-left mb-0">City</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item "><a href="{{url('admin/countries')}}">Country</a>
                                </li>
                                <li class="breadcrumb-item "><a href="{{url('admin/state').'/'.$state->state_id}}">State</a>
                                </li>
                                <li class="breadcrumb-item active">City
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
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-toggle="modal" data-target="#myModal">New city</button>
                        </div>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">City</h4>
                            </div>
                            <div class="card-datatable datatable-row-remove">
                                {!! $html->table(['class' => 'table dt-complex-header table-bordered ','id'=>'datatable']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
 {{--  add new modal  --}}
 <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">New City</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="form-horizontal" id="userForm" role="form" action="{{url('admin/city/new')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="city_state" value="{{$state->state_id}}">
                    <div class="form-group {{ $errors->has('city_name') ? ' has-error' : '' }}">
                        <label  class=" control-label" for="city_name">State Name <span class="colorRed"> *</span></label>
                        <div class="">
                            <input type="text" class="form-control" id="city_name" name="city_name" placeholder="State Name" value="{{old('city_name')}}"/>
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
                        <button type="submit" id="createBtn" class="btn btn-primary pull-right">Create</button>
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
</style>
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
                url  : SITE_URL+'/admin/city/status-change',
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
      
        $('#country').on('change', function() {
            var country_id = $('#country').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type :'POST',
                data : {
                    id:country_id
                },
                url  : SITE_URL+'/getState',
                success  : function(response) {
                    $('#state').html(response);
                }
            });
        });

        $(document.body).on('click', "#createBtn", function(){
            if ($("#userForm").length){
                $("#userForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {
                        "city_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        }
                    },
                    messages: {
                        "city_name":{
                            required:"Enter City Name",
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

        function deleteConfirm(id){
            bootbox.confirm({
            message: "<p class='text-red'>Are you sure you want to delete ?</p>",
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
                            url: SITE_URL + '/admin/city/delete/'+id,
                            success: function (data) {
                                toastr.warning('Country Deleted !!');
                                $('#datatable').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                }
            })
        }
    </script>
@endsection
