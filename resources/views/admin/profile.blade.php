@extends('admin.layouts.app')
@section('title')
    Profile |
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
                            <h2 class="content-header-title float-left mb-0">Profile</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item "><a href="{{ url('admin/dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Profile
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- users edit start -->
                <section class="app-user-edit">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center @if(!app('request')->input('redirect') || app('request')->input('redirect') != "Authnticator") active @endif" id="account-tab" data-toggle="tab"
                                        href="#account" aria-controls="account" role="tab" aria-selected="true">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span class="d-none d-sm-block">Account</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="password-tab" data-toggle="tab"
                                        href="#password" aria-controls="password" role="tab" aria-selected="false">
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                        <span class="d-none d-sm-block">Password</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="setting-tab" data-toggle="tab"
                                        href="#setting" aria-controls="setting" role="tab" aria-selected="false">
                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                        <span class="d-none d-sm-block">Setting</span>
                                    </a>
                                </li>                                
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane @if(!app('request')->input('redirect') || app('request')->input('redirect') != "Authnticator") active @endif" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <form class="form-horizontal" id="profileForm" method="post"
                                        action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="media mb-2">
                                            <img src="@if ($user->profile_picture) {{ $user->profile_picture }} @else {{ URL::asset('/resources/assets/img/default.png') }} @endif"
                                                class="gambar old_profile_imageSub user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer"
                                                id="item-img-output" name="avatar" style="object-fit: cover;"
                                                height="90" width="90" />

                                            <div class="media-body mt-50">
                                                <div class="col-5 d-flex mt-1 px-0">
                                                    <input type="hidden" name="main_image" value="" id="main_image"
                                                        style="">
                                                    <input type="file" accept="image/png, image/jpeg, image/jpg"
                                                        class="item-img file form-control " name="file_photo" />
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('main_image') ? ' has-error' : '' }}">
                                                <div class="col-md-8 vc_column-inner ">
                                                    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog"
                                                        aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog  ">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">×</span></button>
                                                                    <h4 class="modal-title" id="myModalLabel">
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="upload-demo" class="center-block"></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-default"
                                                                        id="Flip">Flip</button>
                                                                    <button type="button" id="cropImageBtn"
                                                                        class="btn btn-primary">Crop</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Name</label>
                                                    <div class=" jointbox">
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" value="{{ $user->first_name }}" placeholder="Name">
                                                        @if ($errors->has('name'))
                                                            <span class="help-block alert alert-danger">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="email" class=" control-label">Email</label>
                                                    <div class="">
                                                        <input type="email" class="form-control" name="email"
                                                            id="email" value="{{ $user->email }}"
                                                            placeholder="eg. abc@gmail.com" readonly>
                                                        @if ($errors->has('email'))
                                                            <span class="help-block alert alert-danger">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mobile_number" class=" control-label">Phone number</label>
                                                    <div class="">
                                                        <input type="text" class="form-control" name="mobile_number"
                                                            id="mobile_number" value="{{ $user->mobile_number }}"
                                                            placeholder="eg. 9904132640">
                                                        @if ($errors->has('mobile_number'))
                                                            <span class="help-block alert alert-danger">
                                                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="" style="border-top:0">
                                                    <div class="box-footer">
                                                        <span class="help-block"> <span class="colorRed"> *</span>
                                                            mentioned fields are mandatory.</span>
                                                        <button type="submit" id="createBtn"
                                                            class="btn btn-primary pull-right"
                                                            style="margin-left: 20px;float:right;">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="password" aria-labelledby="password-tab" role="tabpanel">
                                    <!-- users edit Info form start -->
                                    <form class="form-horizontal" id="passwordForm" method="post"
                                        action="{{ route('profile.update', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="old_password" class=" control-label">Current</label>
                                                    <div class="">
                                                        <input type="password" name="old_password" id="old_password"
                                                            class="form-control" placeholder="Your current password">
                                                        @if ($errors->has('old_password'))
                                                            <span class="help-block alert alert-danger">
                                                                <strong>{{ $errors->first('old_password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password" class=" control-label">New</label>
                                                    <div class="">
                                                        <input type="password" name="new_password" id="new_password"
                                                            class="form-control" placeholder="New password">
                                                        @if ($errors->has('new_password'))
                                                            <span class="help-block alert alert-danger">
                                                                <strong>{{ $errors->first('new_password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password" class=" control-label">Confirm</label>
                                                    <div class="">
                                                        <input type="password" name="confirm_password"
                                                            id="confirm_password" class="form-control"
                                                            placeholder="Confirm password">
                                                        @if ($errors->has('confirm_password'))
                                                            <span class="help-block alert alert-danger">
                                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="" style="border-top:0">
                                                    <div class="box-footer">
                                                        <span class="help-block"> <span class="colorRed"> *</span>
                                                            mentioned fields are mandatory.</span>
                                                        <button type="submit" id="createBtn2"
                                                            class="btn btn-primary pull-right"
                                                            style="margin-left: 20px;float:right;">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit Info form ends -->
                                </div>
                                <div class="tab-pane" id="setting" aria-labelledby="setting-tab" role="tabpanel">
                                    <!-- users edit Info form start -->
                                    <form class="form-horizontal" id="settingForm" method="post"
                                        action="{{ route('profile.update', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="password_reset_frequency" class=" control-label">Password
                                                        Reset Frequency</label>
                                                    <div class="">
                                                        <input type="number" name="password_reset_frequency"
                                                            id="password_reset_frequency" class="form-control"
                                                            placeholder="In Days Ex.365" value="{{ $user->password_reset_frequency }}">
                                                        @if ($errors->has('password_reset_frequency'))
                                                            <span class="help-block alert alert-danger">
                                                                <strong>{{ $errors->first('password_reset_frequency') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="" style="border-top:0">
                                                    <div class="box-footer">
                                                        <span class="help-block"> <span class="colorRed"> *</span>
                                                            mentioned fields are mandatory.</span>
                                                        <button type="submit" id="createBtn3"
                                                            class="btn btn-primary pull-right"
                                                            style="margin-left: 20px;float:right;">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit Info form ends -->
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
    <style type="text/css">
        #pswd_info {
            position: absolute;
            bottom: 70px;
            left: 800px;
            width: 144px;
            padding: 5px;
            background: #fefefe;
            font-size: .750em;
            border-radius: 5px;
            box-shadow: 0 1px 3px #ccc;
            border: 1px solid #ddd;
            height: 165px;
        }

        #pswd_info h4 {
            margin: 0 0 10px 0;
            padding: 0;
            font-weight: normal;
        }

        #pswd_info::before {
            content: "\25b6";
            position: absolute;
            top: 62px;
            right: 95%;
            font-size: 30px;
            line-height: 14px;
            color: white;
            text-shadow: none;
            display: block;
        }

        .invalid {
            background: url('{{ URL::asset('/resources/assets/img/invalid.png') }}') no-repeat 0 50%;
            padding-left: 22px;
            line-height: 24px;
            color: black;
        }

        .valid {
            background: url('{{ URL::asset('/resources/assets/img/valid.png') }}') no-repeat 0 50%;
            padding-left: 22px;
            line-height: 24px;


        }

        #pswd_info {
            display: none;
        }

        .pp {
            font-size: 12px;
            font-style: bold;
        }

        #pswd_info ul {
            padding: 0px;
        }

        #pswd_info li {
            list-style: none;
        }

        #my_camera {
            border: 1px solid black;
            margin-left: 30px;
        }
    </style>
@endsection
@section('script')
    @if (Session::has('message'))
        <script>
            $(function() {
                toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
            });
        </script>
    @endif
    @if (Session::has('status'))
    @endif
    <script type="text/javascript" src="{{ URL::asset('resources/assets/webcam/webcamjs/webcam.min.js') }}"></script>
    <script>
        $(document).ajaxStart(function() {
            Pace.restart();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var SITE_URL = "<?php echo URL::to('/'); ?>";

        $(document).ready(function() {
            $('input[type=password]').keyup(function() {
                $('#password_confirmation').on('keyup', function() {
                    $('#pswd_info').hide();
                });
                // keyup event code here
            });
            $('input[type=password]').focus(function() {
                // focus code here
            });
            $('input[type=password]').blur(function() {

                $('#new_password').removeClass('valid');
                // blur code here
            });
            $('input[type=password]').keyup(function() {
                // keyup code here
            }).focus(function() {
                // focus code here

            }).blur(function() {
                // blur code here
            });

            $('#new_password').keyup(function() {
                // keyup code here
                var pswd = $(this).val();
                //validate the length
                if (pswd.length < 8) {
                    $('#length').removeClass('valid').addClass('invalid');
                } else {
                    $('#length').removeClass('invalid').addClass('valid');
                }

                //validate letter
                if (pswd.match(/[a-z]/)) {
                    $('#letter').removeClass('invalid').addClass('valid');
                } else {
                    $('#letter').removeClass('valid').addClass('invalid');
                }

                //validate capital letter
                if (pswd.match(/[A-Z]/)) {
                    $('#capital').removeClass('invalid').addClass('valid');
                } else {
                    $('#capital').removeClass('valid').addClass('invalid');
                }

                //validate number
                if (pswd.match(/\d/)) {
                    $('#number').removeClass('invalid').addClass('valid');
                } else {
                    $('#number').removeClass('valid').addClass('invalid');
                }
                if (/^[a-zA-Z0-9- ]*$/.test(pswd) == false) {
                    $('#special').removeClass('invalid').addClass('valid');
                } else {
                    $('#special').removeClass('valid').addClass('invalid');
                }

            }).focus(function() {
                $('#pswd_info').show();
            }).blur(function() {
                $("#pswd_info").hide();

            });
        });
        $('#password_confirmation').on('click', function() {
            $('#pswd_info').hide();
        });
    </script>

    <script src="{{ URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js') }}"></script>
    <script src="{{ URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js') }}"></script>
    <script>
        $.validator.addMethod("pass", function(value, element) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value);
        }, "Please enter valid password.");
        $(document.body).on('click', "#createBtn", function() {
            var id = "{{ $user->id }}";
            if ($("#profileForm").length) {
                $("#profileForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {
                        "name": {
                            required: true,
                        },
                        "email": {
                            required: true,
                            email: true
                        },
                        "mobile_number": {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 12,
                            remote: {
                                data: {
                                    id: id,
                                    type: '1'
                                },
                                url: SITE_URL + '/check-number-exsist',
                                type: "get",
                            }
                        },
                    },
                    messages: {
                        "name": {
                            required: "Please enter name."
                        },

                        "email": {
                            required: "Please enter email."
                        },
                        "mobile_number": {
                            required: "Please enter mobile no."
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                });
            }
        });
        $.validator.addMethod("password_length", function(value, element) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^.()_-])[A-Za-z\d@$!%*?&#^.()_-]{8,18}$/.test(
                value);
        }, "Enter combination of at least 8 number, letters and special characters.");
        $(document.body).on('click', "#createBtn2", function() {
            if ($("#passwordForm").length) {
                $("#passwordForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {
                        "old_password": {
                            required: true
                        },
                        "new_password": {
                            required: true,
                            password_length: true,
                        },
                        "confirm_password": {
                            required: true,
                            equalTo: "#new_password"
                        },
                    },
                    messages: {
                        "old_password": {
                            required: "Please enter current password."
                        },
                        "new_password": {
                            required: "Please enter new password.",
                            pass: "Password should contain number,characters,special character and atleast one capital letter."
                        },
                        "confirm_password": {
                            required: "Please enter confirm password.",
                            equalTo: "Please enter same as new password."
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                });
            }
        });

        $(document.body).on('click', "#createBtn3", function() {
            if ($("#settingForm").length) {
                $("#settingForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red text-danger',
                    ignore: [],
                    rules: {
                        "password_reset_frequency": {
                            required: true
                        }
                    },
                    messages: {
                        "password_reset_frequency": {
                            required: "Please enter password reset frequency."
                        }
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                });
            }
        });

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
                    reader.onload = function(e) {
                        $('.upload-demo').addClass('ready');
                        $('#cropImagePop').modal('show');
                        rawImg = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);

                } else {
                    swal("Only JPEG, PNG, JPG file types are supported");
                }
            } else {
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
            enableResize: true,
        });
        $('#cropImagePop').on('shown.bs.modal', function() {
            // alert('Shown pop');
            $uploadCrop1.croppie('bind', {
                url: rawImg
            }).then(function() {
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

        $('.item-img').on('change', function() {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });
        $('#cropImageBtn').on('click', function(ev) {
            $uploadCrop1.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {
                    width: 1280,
                    height: 720
                }
            }).then(function(resp) {
                $('#item-img-output').attr('src', resp);
                $('#main_image').attr('value', resp);
                $('#cropImagePop').modal('hide');
            });
        });
        // End upload preview image
    </script>
@endsection
