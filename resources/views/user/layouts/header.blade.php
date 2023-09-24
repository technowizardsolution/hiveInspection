@if(request()->get('app'))
@elseif(Auth::check())
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
                    <div class="login-btn" style="z-index:9999">
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
