
@extends('admin.layouts.app')
@section('title') Update Sub Admin | @endsection

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Update Sub Admin</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Update Sub Admin
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
                                <h4 class="card-title">Update Sub Admin</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" id="empForm" action="{{url('admin/subadmins').'/'.$user->id}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                    <div class="media mb-2">
                                        <img src="@if($user->profile_picture){{ $user->profile_picture}} @else {{  URL::asset('/resources/assets/img/default.png')}} @endif" class="gambar old_profile_imageSub user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" id="item-img-output"  name="avatar" style="object-fit: cover;" height="90" width="90"/>
                                        <div class="media-body mt-50">
                                            <div class="col-5 d-flex mt-1 px-0">
                                                {{-- <label class="btn btn-primary mr-75 mb-0" for="change-picture"> --}}
                                                    <input type="hidden" name="main_image" value="" id="main_image" style="">
                                                    {{-- <span class="d-none d-sm-block">Change</span> --}}
                                                    <input type="file" accept="image/png, image/jpeg, image/jpg" class="item-img file form-control " name="file_photo" />
                                                {{-- </label> --}}
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('main_image') ? ' has-error' : '' }}">
                                            <div class="col-md-8 vc_column-inner ">
                                                <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog  ">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">
                                                            </div>
                                                            <div class="modal-body">
                                                                <div id="upload-demo" class="center-block"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-default" id="Flip">Flip</button>
                                                                {{-- <button class="btn btn-default" id="rotate" data-deg="-90">Rotate</button>--}}
                                                                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>
                                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label  class=" control-label" for="name">Name <span class="colorRed"> *</span></label>
                                                <div class="jointbox">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="@if(!empty(old('name'))){{old('name')}}@else{{$user->first_name}}@endif"/>
                                                    @if ($errors->has('name'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label  class="control-label" for="email">Email <span class="colorRed"> *</span></label>
                                                <div class="">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="@if(!empty(old('email'))){{old('email')}}@else{{$user->email}}@endif"/>
                                                    @if ($errors->has('email'))
                                                    <span class="help-block alert alert-danger">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="login-password">Password</label>
                                                </div>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input id="password" type="password" class="form-control form-control-merge {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" aria-describedby="password" tabindex="2" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="login-password">Confirm Password</label>
                                                </div>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control form-control-merge @error('password-confirm') is-invalid @enderror" name="password_confirmation" autocomplete="new-password" tabindex="3">
                                                    <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
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
        window.location.href = "{{url('admin/subadmins')}}";
    });
$(document).ajaxStart(function() { Pace.restart(); });
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $.validator.addMethod("password_length", function(value, element) {
        if(value.length > 1) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^.()_-])[A-Za-z\d@$!%*?&#^.()_-]{8,18}$/.test(value);
        }else{
            return true;
        }
    }, "Enter combination of at least 8 number, letters ,special character and atleast one capital letter.");
    $.validator.addMethod("email", function(value, element) {
        return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, "Please enter valid email.");
    $(document.body).on('click', "#updateBtn", function(){
        var id = "{{$user->id}}";
        if ($("#empForm").length){
            $("#empForm").validate({
              errorElement: 'span',
                      errorClass: 'text-red text-danger',
                      ignore: [],
                      rules: {
                        "name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                       
                        "email":{
                          required:true,
                          email:true,
                          remote: {
                                data:{id:id,type:'1'},
                                url: SITE_URL + '/check-email-exsist',
                                type: "get",
                            }
                        },
                        "password":{
                            minlength: 8,
                            maxlength: 20,
                            password_length:true,
                        },
                        "password_confirmation":{
                            equalTo:'#password',
                        },
                    },
                    messages: {
                       "email":{
                            required:"Please enter email.",
                            remote:"Provided email already used by some one.",

                        },
                          "name":{
                            required:"Please enter name.",
                        },
                         
                          "mobile_number":{
                            required:"Please enter mobile number.",
                            minlength: "Please enter at least 10 digits.",
                              maxlength: "Please do not enter more than 15 digits.",
                              remote:"Provided number has already been used by someone else.",
                        },
                        "dob":{
                          required:"Please select date of birth.",
                        },
                          
                        "country":{
                          required:"Please select country.",
                        },
                        "state":{
                          required:"Please select state.",
                        },
                        "city":{
                          required:"Please select city.",
                        },
                        "password_confirmation":{
                            required:"Please enter confirm password.",
                            equalTo: "Please enter same as password.",
                        },
                        "password":{
                            required:"Please enter password.",
                        },
                       
                      },
                      errorPlacement: function(error, element) {
                      if(element.is('select')){
                            error.appendTo(element.closest("div"));
                        }else{
                            error.insertAfter(element.closest(".form-control"));
                        }
                        error.insertAfter(element.closest(".input-group"));
                      },
              });
        }
    });
    var SITE_URL = "<?php echo URL::to('/'); ?>";
</script>

<script>
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

</script>
<script type="text/javascript">
    // Start upload preview image
    var FLIP = 2;
    var NORMAL = 1;
    var orientation = NORMAL;
    var $uploadCrop1, tempFilename, rawImg, imageId;
    var fileTypes = ['jpg', 'jpeg', 'png'];
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var file = input.files[0]; // Get your file here
            var fileExt = file.type.split('/')[1]; // Get the file extension
            if (fileTypes.indexOf(fileExt) !== -1) {
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);

            }else{
                swal("Only JPEG, PNG, JPG file types are supported");
            }
        }
        else {
            swal("Sorry - something went wrong");
        }
    }

    $uploadCrop1 = $('#upload-demo').croppie({
        viewport: {
            width: 480,
            height: 270,
        // type: 'square'
        },
        enableOrientation: true,
        enforceBoundary: false,
        enableExif: true,
        enableResize:true,
    });
    $('#cropImagePop').on('shown.bs.modal', function(){
        // alert('Shown pop');
        $uploadCrop1.croppie('bind', {
            url: rawImg
            }).then(function(){
                // console.log('jQuery bind complete');
            });
    });
    $('#Flip').click(function() {
            orientation = orientation == NORMAL ? FLIP : NORMAL;
            $uploadCrop1.croppie('bind', {
            url: rawImg,
            orientation: orientation,
        });
    });
    $('#rotate').click(function() {
        $uploadCrop1.croppie('rotate', parseInt($(this).data('deg')));
    });
    $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId); readFile(this); });
    $('#cropImageBtn').on('click', function (ev) {
            $uploadCrop1.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {width: 1280, height: 720}
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            $('#main_image').attr('value', resp);
            $('#cropImagePop').modal('hide');
        });
    });
    // End upload preview image
</script>
@endsection
