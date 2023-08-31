<!DOCTYPE html>

<html class="loading @auth {{auth()->user()->theam_mode}} @endauth" lang="en" data-textdirection="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
        <title> @yield('title') {{ config('app.name', 'Xcash') }}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ URL::asset('resources/uploads/logo/fav.png')}}" />
        @include('admin.layouts.css')
        @yield('css')


    </head>

    {{-- <body class="hold-transition skin-black sidebar-mini">
        <div class="wrapper" id="app">
            @include('admin.layouts.header')
            @include('admin.layouts.sidebar')
            @yield('content')
            @include('admin.layouts.footer')
        </div>
        <script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
        @if(Request::is('*/chat/*'))
            <script type='text/javascript' src="{{URL::asset('/resources/assets/admin/plugins/moment/moment.min.js')}}"></script>
            <script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
            <script>
                // Initialize Firebase
                var config = {
                    apiKey: "{{ env('FIREBASE_APIKEY') }}",
                    authDomain: "{{ env('FIREBASE_AUTHDOMAIN') }}",
                    databaseURL: "{{ env('FIREBASE_DATABASEURL') }}",
                    projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
                    storageBucket: "{{ env('FIREBASE_STORAGEBUCKET') }}",
                    messagingSenderId: "{{ env('FIREBASE_MESSAGINGSENDER_ID') }}"
                };
                firebase.initializeApp(config);

                const database = firebase.database();
                $(window).on("load",function(e){
                    $( "#msg_back" ).click(function() {
                        $("#chating_box").hide();
                    });
                });

            </script>
        @endif
        <script src="{{ URL::asset('public/js/app.js') }}"></script>
        @include('admin.layouts.js')
        @yield('script')

    </body> --}}
    <body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
            <!-- BEGIN: Header-->
            @include('admin.layouts.header')
            <!-- END: Header-->

            <!-- BEGIN: Main Menu-->
            @include('admin.layouts.sidebar')
            <!-- END: Main Menu-->

            <!-- BEGIN: Content-->
            @yield('content')

            <!-- END: Content-->

            <div class="sidenav-overlay"></div>
            <div class="drag-target"></div>

            <!-- BEGIN: Footer-->
            @include('admin.layouts.footer')
        {{-- <script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
        @if(Request::is('*/chat/*'))
            <script type='text/javascript' src="{{URL::asset('/resources/assets/admin/plugins/moment/moment.min.js')}}"></script>
            <script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
            <script>
                // Initialize Firebase
                var config = {
                    apiKey: "{{ env('FIREBASE_APIKEY') }}",
                    authDomain: "{{ env('FIREBASE_AUTHDOMAIN') }}",
                    databaseURL: "{{ env('FIREBASE_DATABASEURL') }}",
                    projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
                    storageBucket: "{{ env('FIREBASE_STORAGEBUCKET') }}",
                    messagingSenderId: "{{ env('FIREBASE_MESSAGINGSENDER_ID') }}"
                };
                firebase.initializeApp(config);

                const database = firebase.database();
                $(window).on("load",function(e){
                    $( "#msg_back" ).click(function() {
                        $("#chating_box").hide();
                    });
                });

            </script>
        @endif
        <script src="{{ URL::asset('public/js/app.js') }}"></script> --}}
            @include('admin.layouts.js')
            @yield('script')
    </body>
</html>
