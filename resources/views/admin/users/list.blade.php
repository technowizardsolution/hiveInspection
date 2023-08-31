@section('title') Users | @endsection
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
                        <h2 class="content-header-title float-left mb-0">Users</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Users
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

                {{--<form method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div id="my_camera"></div>
                        <br/>
                        <input type=button value="Take Snapshot" onClick="take_snapshot()">
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-md-6">
                        <div id="results">Your captured image will appear here...</div>
                    </div>
                    <div class="col-md-12 text-center">
                        <br/>
                        <button class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form> --}}

                   <div class="col-sm-12 pull-right  " style="padding-bottom: 10px;">
                    @can('user-create')
                      <a href="{{route('users.create')}}" class="float-right">
                        <button type="button" class="btn btn-primary waves-effect waves-float waves-light">New User</button>
                      </a>
                    @endcan

                  </div>
                   <div class="clear-fix"></div>
                  <div class="col-12">
                      <div class="card">
                          <div class="card-header border-bottom">
                              <h4 class="card-title">Users</h4>
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
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Google 2FA Code</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Set up your two factor authentication by scanning the qrcode below. Alternatively, you can use the code <strong id="qrcode_code"></strong></p>
        <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
        <p id="qrcode" style="text-align:center;"></p>
      </div>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>

  var SITE_URL = "<?php echo URL::to('/'); ?>";
// change user Status
  $(document.body).on('click', '.actStatus' ,function(event){
    var row = this.id;
    var dbid = $(this).attr('data-sid');
    bootbox.confirm({
      message: "Are you sure you want to change user status ?",
      buttons: {'cancel': { label: 'No',className: 'btn-danger'},
      'confirm': { label: 'Yes',className: 'btn-success'}
    },
    callback: function(result){
      if (result){
        $.ajax({
          type :'POST',
          data : {id:dbid, _token:'{{ csrf_token() }}'},
          url  : 'users/status-change',
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

  function showQRCode(id){
    $.ajax({
      url: SITE_URL + '/admin/users/getAuthenticatorQrCode/'+id,
      type: "Get",
      success: function (data) {
        $('#qrcode_code').html(data.code);
        $('#qrcode').html(data.html);
        $('#myModal').modal("show");
      }
    });
  }

  function deleteConfirm(id){
    if(id==1){
       bootbox.alert("You can't delete Super Admin");
    }
    else{
    bootbox.confirm({
      message: "Are you sure you want to delete ?",
      buttons: {'cancel': {label: 'No',className: 'btn-danger'},
                'confirm': {label: 'Yes',className: 'btn-success'}
      },
      callback: function(result){
        if (result){
          $.ajax({
            url: SITE_URL + '/admin/users/'+id,
            type: "DELETE",
            cache: false,
            data:{ _token:'{{ csrf_token() }}'},
            success: function (data, textStatus, xhr) {
              if(data== true && textStatus=='success' && xhr.status=='200')
              {
                  toastr.warning('User Deleted !!');
                  $('#UserDataTable').DataTable().ajax.reload(null, false);
              }
              else {  toastr.error(data); }
            }
          });
        }
      }
    });
  }
  }

  {{-- Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    } --}}
</script>
@endsection
