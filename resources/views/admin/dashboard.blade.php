@extends('admin.layouts.app')
@section('title')
@endsection

@section('css')
<link rel="stylesheet" href="{{URL::asset('resources/assets/admin/plugins/daterangepicker/daterangepicker.css')}}">
@endsection
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Dashboard</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="javascript:;">Admin</a>
                                </li>
                                <li class="breadcrumb-item active">Dashboard
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 form-group">
              <input type="text" id="fp-range" class="form-control flatpickr-range flatpickr-input active fp-range" placeholder="YYYY/MM/DD - YYYY/MM/DD" readonly="readonly">
            </div>
        </div>
        <div class="content-body">
            <!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row match-height">
                  <div class="col-xl-12 col-md-6 col-12">
                      <div class="card card-statistics">
                          <div class="card-header">
                              <h4 class="card-title">Statistics</h4>
                          </div>
                          <div class="card-body statistics-body">
                              <div class="row">
                                  <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                      <div class="media">
                                          <div class="avatar bg-light-primary mr-2">
                                              <div class="avatar-content">
                                                  <i class="fa fa-users ont-medium-5" aria-hidden="true"></i>
                                              </div>
                                          </div>
                                          <div class="media-body my-auto">
                                              <h4 class="font-weight-bolder mb-0" id="usercount"></h4>
                                              <p class="card-text font-small-3 mb-0">Hive</p>
                                              <p>
                                                <a href="{{url('admin/hive')}}" class="small-box-footer">
                                                  More info
                                                </a>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                      <div class="media">
                                          <div class="avatar bg-light-info mr-2">
                                              <div class="avatar-content">
                                                  <i class="fa fa-users ont-medium-5" aria-hidden="true"></i>
                                              </div>
                                          </div>
                                          <div class="media-body my-auto">
                                              <h4 class="font-weight-bolder mb-0" id="totalSubadmin"></h4>
                                              <p class="card-text font-small-3 mb-0">Inspection</p>
                                              <p>
                                                <a href="{{url('admin/inspection')}}" class="small-box-footer text-info">
                                                  More info
                                                </a>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </section>            
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js')}}"></script>
<script src="{{URL::asset('resources/assets/admin/plugins/daterangepicker/moment.js')}}"></script>
<script src="{{URL::asset('resources/assets/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script>

function getData(){
    var xMonth = [];
    var yData = [];
    var currentYear = new Date().getFullYear();
    console.log(currentYear);
    $.ajax({
        url: "{{ route('getUsersData') }}",
        type: 'GET',
        dataType: 'JSON',
        success: function(result){
            jQuery.each(result, function(index, item) {
                xMonth.push(item.month);
                yData.push(item.count);

            //now you can access properties using dot notation
            console.log(item.month);
        });
            console.log(result);
    //   $("#div1").html(result);


    new Chart("myChart", {
      type: "bar",
      data: {
        labels: xMonth,
        datasets: [{
          backgroundColor:'#00cfe8',
          data: yData
        }]
      },
      options: {
        legend: {display: false},
        title: {
          display: true,
          text: "User Data " + currentYear,
        }
      }
    });
    }});
}
getData();

    </script>

@if(Session::has('message'))
    <script>
        $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
    </script>
@endif
<script>
    $(document).ajaxStart(function() {
        Pace.restart();
    });
</script>

<script>
var SITE_URL = '<?php echo URL::to('/').'/'; ?>';

//Date range as a button
  $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment(),
      maxDate: new Date()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            //   var start_date = start.format('MMMM D, YYYY');
            //   var end_date = end.format('MMMM D, YYYY')
            //     $.ajax({
            //     url: SITE_URL + 'admin/dashboardFilterData',
            //     type: 'POST',
            //     dataType: 'html',
            //     data: {"_token": "{{ csrf_token() }}",start_date: start_date,end_date: end_date},
            //     success: function (data) {
            //         $("#usercount").html(data);
            //     }
            // });
    }
  )
  $(document).ready(function() {
    var date = $("#fp-range").val();
    dateFilter(date);
  });
  $(document.body).on('click', ".daterangepicker .ranges ul li,.applyBtn", function(){
    var date = $("#daterange-btn span").text();
    // $('.ranges ul li').each(function(index, elem) {
    //   $(elem).removeClass('active');
    // });
    dateFilter(date);
  });
  $(document.body).on('change','#fp-range', function(){
    var date = $("#fp-range").val();
    dateFilter(date);
  });

  function dateFilter(date){
    $.ajax({
      url: SITE_URL + 'admin/dashboardFilterData',
      type: 'POST',
      dataType: 'html',
      data: {"_token": "{{ csrf_token() }}",date},
      success: function (data) {
        data =JSON.parse(data);
        $("#usercount").html(data.totalUser);
        $("#totalSubadmin").html(data.totalSubadmin);
      }
    });
  }



</script>
@endsection
