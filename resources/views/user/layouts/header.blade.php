@if(isset($app) && $app)
@else
<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-header">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                           <img alt="Logo" src="{{ URL::asset('public/images/logo.png') }}">
                        </a>
                    </div>
                    <div class="login-btn">
                        <!-- <a href="{{ url('about') }}">About</a> -->
                        <a href="{{ route('logout') }}" title="@lang('messages.logout')"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="btn-login">
                            @lang('messages.logout')
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                        </form>
                                    

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@endif
