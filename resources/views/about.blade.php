@extends('user.layouts.authapp')
@section('content')
<section class="form-section about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-card-box">
                        @if($about && $about->page_title)
                        <h1>{!! $about->page_title !!} </h1>
                        @endif

                        @if($about && $about->content)
                        <p>{!! $about->content !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
