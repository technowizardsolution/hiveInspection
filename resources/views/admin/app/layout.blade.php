<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>@yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('public/semantic/dist/semantic.min.css') }}">

    <style type="text/css">
    body {
      background-color: #DADADA;
    }
    [v-cloak] {
      display: none;
    }
    </style>

    </script>
</head>

<body>

    <!-- NAVBAR -->
    <div class="ui large top fixed menu transition visible" style="display: flex !important;">
      <div class="ui container">
        <a href="{{url('admin/dashboard')}}" class="item"><i class="user circle icon"></i> {{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
        <div class="right menu">
          <div class="item">
            <a id="logoutButton" class="ui red button"><i class="sign out icon"></i> Back</a>
          </div>
        </div>
      </div>
    </div>
    <!-- END NAVBAR -->

    @yield('content')

    <div id="logoutModal" class="ui basic modal">
      <div class="ui icon header">
        <i class="sign out icon"></i>
        Are you sure you want go back ?
      </div>
      <div class="actions" style="text-align: center;">
        <div class="ui red basic cancel inverted button">
          <i class="remove icon"></i>
          No
        </div>
        <a href="{{url('admin/dashboard')}}" class="ui green ok inverted button">
          <i class="checkmark icon"></i>
          Yes
        </a>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="{{ asset('public/semantic/dist/semantic.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.special.cards .image').dimmer({
                on: 'hover'
            });
            $('#logoutButton').click(function(){
                $('#logoutModal').modal('show');
            })
        });

    </script>

    @yield('script')

</body>
</html>
