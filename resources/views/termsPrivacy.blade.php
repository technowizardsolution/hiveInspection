@extends('user.layouts.authapp')
@section('content')
<section class="form-section about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="step-info-card">
                        <div class="about-card-box">
                            @if($privacy && $privacy->page_title)
                            <h1>{!! $privacy->page_title !!} </h1>
                            @endif

                            @if($privacy && $privacy->content)
                            <p>{!! $privacy->content !!}</p>
                            @endif
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </section>
@endsection
