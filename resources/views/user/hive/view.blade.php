@extends('user.layouts.authapp')
@section('title') Hive | @endsection
@section('content')

<section class="form-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="step-info-card">

                    <div class="main-section">
                        <div class="main-tittle">
                           <h4><b>Hive Details</b></h4> 
                        </div>
                        <div class="main-button">
                            <a class="btn btn-primary hive-button" href="{{url('user/hive/add')}}">Add Hive</a>
                        </div>                       
                    </div>

                    <section id="hive-card">
                        <div class="row">
                            @if(count($records) > 0)
                            @foreach($records as $key=>$data)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="main-section">
                                            <div class="main-tittle">
                                                <h5 class="card-title">{{$data->hive_name}}</h5>                                 
                                            </div>
                                            <div class="main-button">
                                            <a class="btn btn-success" href="{{url('user/hive/edit',$data->hive_id)}}"  title="Edit"><i class='fa fa-edit'></i></a>
                                            <a class="btn btn-danger" onclick="deleteConfirm({{$data->hive_id}})" href="javascript:;"  title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            </div>                       
                                        </div>

                                        <p class="card-text">
                                            <strong> Location : </strong> {{$data->location}}
                                        </p>   
                                        <p class="card-text">
                                            <strong> Build date : </strong> {{$data->build_date}}
                                        </p>                                    
                                        <p class="card-text">
                                            <strong> Origin : </strong> {{$data->origin}}
                                        </p>
                                        <p class="card-text">
                                            <strong> Deeps : </strong> {{$data->deeps}}
                                        </p>
                                        <p class="card-text">
                                            <strong> Mediums : </strong> {{$data->mediums}}
                                        </p>
                                        <p class="card-text">
                                            <strong> Queen introduced : </strong> {{$data->queen_introduced}}
                                        </p>                                                

                                        <a class="btn btn-primary hive-button" href="{{url('user/inspection',$data->hive_id)}}">Start inspecting!</a>
                                        <a class="btn btn-primary hive-button" href="{{url('/user/inspection/export')}}">Export report</a>
                                        
                                    </div>
                                </div>
                                <br/>
                            </div>
                            
                            @endforeach
                            @else
                            <div class="col-md-6 col-lg-4">
                                <div class="card" style="width: 454px;">
                                    <h3>No record found!</h3>
                                </div>
                            </div>
                            @endif
                        </div>
                    </section>
                    {{ $records->links() }}
                
                                     
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
                "location":{
                    required:true
                },
                "build_date":{
                    required:true,                            
                },
                "origin":{
                    required:true,                            
                },
                "deeps":{
                    required:true,                            
                },
                "mediums":{
                    required:true,                            
                },
                "queen_introduced":{
                    required:true,                            
                }

            },
            messages: {
                "hive_name":{
                    required:"Please enter hive name.",
                },
                "location":{
                    required:"Please enter location.",
                },
                "build_date":{
                    required:"Please enter build date.",                            
                },
                "origin":{
                    required:"Please enter origin.",                            
                },
                "deeps":{
                    required:"Please enter deeps.",                            
                },
                "mediums":{
                    required:"Please enter mediums.",                            
                },
                "queen_introduced":{
                    required:"Please enter queen introduced.",                            
                }                        
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



function deleteConfirm(id){
    bootbox.confirm({
      message: "Are you sure you want to delete ?",
      buttons: {'cancel': {label: 'No',className: 'btn-danger'},
                'confirm': {label: 'Yes',className: 'btn-success'}
      },
      callback: function(result){
        if (result){
          $.ajax({
            url: SITE_URL + '/user/hive/'+id,
            type: "DELETE",
            cache: false,
            data:{ _token:'{{ csrf_token() }}'},
            success: function (data, textStatus, xhr) {
              if(data== true && textStatus=='success' && xhr.status=='200')
              {
                  toastr.warning('Hive Deleted !!');                  
              }
              else {  toastr.error(data); }
            }
          });
        }
      }
    });
  }
</script>

@endsection
