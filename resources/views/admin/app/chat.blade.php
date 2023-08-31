@extends('admin.app.layout')

@section('title', 'Chat | Laravel Chat')

@section('content')
    <div id="app" class="ui main container" style="margin-top:65px;">
        <div class="ui grid">
            <div class="row">
                <div class="three wide column">
                    <div class="ui vertical pointing menu">
                        <h3 class="item ui header">
                            Users:
                        </h3>
                        @foreach ($users as $user)
                            @if ($user->id == $receptorUser->id)
                                <a href="{{ route('chat', [$user->id]) }}" class="active item">
                                    {{ $user->first_name }}
                                </a>
                            @else
                                <a href="{{ route('chat', [$user->id]) }}" class="item">
                                    {{ $user->first_name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="thirteen wide column">
                    <div class="ui segment" style="padding: 1.5em 1.5em;">
                        <div class="ui comments" style="max-width: 100%;">
                            <h3 class="ui dividing header"><i class="talk outline icon"></i> Conversation
                                with - {{ $receptorUser->first_name }}</h3>
                            <firebase-messages user-id="{{ Auth::user()->id }}" chat-id="{{ $chat->id }}"
                                receptor-name="{{ $receptorUser->first_name }}" projectapi-Url="{{ url('/api/saveLastMessage') }}"></firebase-messages>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
    <script>
        // Initialize Firebase
        // var config = {
        //     apiKey: "{{ env('FIREBASE_APIKEY') }}",
        //     authDomain: "{{ env('FIREBASE_AUTHDOMAIN') }}",
        //     databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
        //     projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        //     storageBucket: "{{ env('FIREBASE_STORAGEBUCKET') }}",
        //     messagingSenderId: "{{ env('FIREBASE_MESSAGINGSENDER_ID') }}",
        //     appId: "{{ env('FIREBASE_APP_ID') }}",
        //     measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
        // };
        const config = {
            apiKey: "AIzaSyA7RP_ZWmTHnJH6dVPsjufVaZW1n0syuGs",
            authDomain: "flowerdemo-390a1.firebaseapp.com",
            databaseURL: "https://flowerdemo-390a1-default-rtdb.firebaseio.com",
            projectId: "flowerdemo-390a1",
            storageBucket: "flowerdemo-390a1.appspot.com",
            messagingSenderId: "633336563598",
            appId: "1:633336563598:web:430891bf044ed48bb8c6df",
            measurementId: "G-D5QCZWVT4D"
        };
        firebase.initializeApp(config);
        const database = firebase.database();
    </script>
    <script src="{{ asset('public/js/myapp.js') }}"></script>
@endsection
