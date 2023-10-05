@extends('user.layouts.authapp')
@section('content')

<style>
    .step-card {
    background: #fff;
    padding: 30px;    
    z-index: 3;
    border-radius: 15px;
}
</style>
<section class="form-section about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="step-card">
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
        </div>
    </section>
@endsection
