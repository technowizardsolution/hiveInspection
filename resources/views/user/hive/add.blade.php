@extends('user.layouts.authapp')
@section('title') Hive | @endsection
@section('content')

<section class="form-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="step-info-card">
                    <form class="form-horizontal" id="hiveForm" role="form" action="{{url('user/hive/store')}}" method="post" enctype="multipart/form-data" >
                        @csrf                           
                        <div class="step-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-title">
                                        <h3>Let's setup your Hives!</h3>
                                    </div>
                                </div>
                            </div>                        
                                                        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('hive_name') ? ' has-error' : '' }}">
                                        <label for="hive_name">Hive Name</label>
                                        <input type="text" class="form-control" name="hive_name" id="hive_name" placeholder="Hive Name">
                                        @if ($errors->has('hive_name'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('hive_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Location</label>
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Build Date</label>
                                        <input type="date" class="form-control" name="build_date" id="build_date" placeholder="Build Date">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Origin</label>
                                        <input type="text" class="form-control" name="origin" id="origin" placeholder="Origin">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Deeps</label>
                                        <input type="number" class="form-control" name="deeps" id="deeps" placeholder="Deeps">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Mediums</label>
                                        <input type="number" class="form-control" name="mediums" id="mediums" placeholder="Mediums">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Queen Introduced</label>
                                        <input type="date" class="form-control" name="queen_introduced" id="queen_introduced" placeholder="Queen Introduced">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="previous-btn">
                                <button type="submit" class="">Add a Hive</button>
                                </div>
                            </div>                            
                        </div>
                    </form>                    
                    <img src="{{ URL::asset('public/images/shap.png')}}" alt="">
                </div> 
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
    @if(Session::has('message'))
        <script>
        $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
        </script>
    @endif
<script>
$(document).ajaxStart(function() { Pace.restart(); });
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var SITE_URL = "<?php echo URL::to('/'); ?>";
$(document.body).on('click', "#hiveForm", function(){
    if ($("#hiveForm").length){
        
        $("#hiveForm").validate({
        errorElement: 'span',
                errorClass: 'text-red text-danger',
                ignore: [],
                rules: {                      
                "hive_name":{
                    required:true
                },
                // "location":{
                //     required:true
                // },
                // "build_date":{
                //     required:true,                            
                // },
                // "origin":{
                //     required:true,                            
                // },
                // "deeps":{
                //     required:true,                            
                // },
                // "mediums":{
                //     required:true,                            
                // },
                // "queen_introduced":{
                //     required:true,                            
                // }

            },
            messages: {
                "hive_name":{
                    required:"Please enter hive name.",
                },
                // "location":{
                //     required:"Please enter location.",
                // },
                // "build_date":{
                //     required:"Please enter build date.",                            
                // },
                // "origin":{
                //     required:"Please enter origin.",                            
                // },
                // "deeps":{
                //     required:"Please enter deeps.",                            
                // },
                // "mediums":{
                //     required:"Please enter mediums.",                            
                // },
                // "queen_introduced":{
                //     required:"Please enter queen introduced.",                            
                // }                        
            },
            errorPlacement: function(error, element) {
                if(element.is('select')){
                    error.appendTo(element.closest("div"));
                }else{
                    error.insertAfter(element.closest(".form-control"));
                }
            },
        });
    }
});
</script>

@endsection
