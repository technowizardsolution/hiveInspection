@extends('admin.app.layout')

@section('title', 'Inicio | Laravel Chat')

@section('content')
    <div class="ui main container" style="margin-top:65px;">
        <div class="ui grid">
            <div class="row">
                <div class="four wide column">
                    <div class="ui cards">
                      <div class="card">
                        <div class="image">
                          <img src="{{asset('resources/uploads/profile/default.jpg')}}">
                        </div>
                        <div class="content">
                          <a class="header">{{ Auth::user()->name }}</a>
                          <div class="meta">
                            <span class="date">Registered {{Auth::user()->created_at->diffForHumans()}}</span>
                          </div>
                        </div>
                        <div class="extra content">
                            <a>
                                <i class="user circle icon"></i>
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </a>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="twelve wide column">
                    <div class="ui segment" style="padding: 1.5em 1.5em;">
                        <h2 class="ui dividing header">
                            Users:
                        </h2>
                        <div id="app" class="ui two columns grid cards ">
                            @foreach($users as $user)
                                <div class="card">
                                    <div class="content">

                                        @if($user->isNew())
                                            <div class="ui yellow right ribbon label">
                                                <i class="star icon"></i> New user
                                            </div>
                                        @else
                                            <div class="ui teal right ribbon label">
                                                <i class="user circle icon"></i> User
                                            </div>
                                        @endif

                                        <div class="header">
                                          <img class="left floated mini ui image" src="{{asset('resources/uploads/profile/default.jpg')}}">
                                          {{$user->first_name}}
                                        </div>
                                        <div class="meta">
                                            Registered {{$user->created_at->diffForHumans()}}
                                        </div>
                                        <div class="description">

                                        </div>
                                    </div>
                                    <div class="extra content">
                                        <div class="ui">
                                            <a href="{{route('chat', [$user->id])}}" class="ui fluid basic teal button"><i class="talk outline icon"></i> chat</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{$users->links()}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
