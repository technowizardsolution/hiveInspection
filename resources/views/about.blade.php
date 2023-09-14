@extends('user.layouts.authapp')
@section('content')
<section class="form-section about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-card-box">
                        <h1>{{$about->page_title}}</h1>

                        <p>{{$about->content}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
