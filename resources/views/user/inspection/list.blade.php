@extends('user.layouts.authapp')
@section('title') Inspection List | @endsection
@section('content')
<style>
  .color-green{
    background-color: #008000;
    display: block;
    color: #fff;
    margin: 0px;
    padding: 0.72rem 2rem;
    font-weight: 600;
  }
  .color-red{
    background-color: #FF0000;
    display: block;
    color: #fff;
    margin: 0px;
    padding: 0.72rem 2rem;
    font-weight: 600;
  }
  .color-yellow{
    background-color: #F4B61A;
    display: block;
    color: #fff;
    margin: 0px;
    padding: 0.72rem 2rem;
    font-weight: 600;
  }
  .color-gray{
    background-color: #adabab;
    display: block;
    color: #fff;
    margin: 0px;
    padding: 0.72rem 2rem;
    font-weight: 600;
  }
  .text-center{
    display: block;
    color: #000;
    margin-top: 10px;
    font-weight: 400;
  }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

table {
    width: 100%;
    border-collapse: collapse;
}
</style>

<section class="form-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="step-info-card">
                    @if($inspectionlist->count())
                    <div class="main-section">
                        <div class="main-tittle">
                           <h4><b>{{$hivedata->hive_name}}</b></h4>
                        </div>
                        <div class="main-button">
                            @if(!request()->get('app'))
                            <a class="btn btn-primary hive-button" href="{{url('/inspectionexport',$hivedata->hive_id)}}">Export Inspection</a>
                            @endif
                            <a class="btn btn-primary hive-button sendReportButton" id="sendReportButton" @if(!request()->get('app')) href="{{url('/sendinspectionreport',$hivedata->hive_id)}}" @else href="{{url('/sendinspectionreport',$hivedata->hive_id).'?app=true'}}" @endif>Send Report To Mail</a>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="table-container">

                      <table id="inspectionTable" class="table table-striped table-bordered table-sm" cellspacing="0"
                      width="100%">
                      <thead>
                          <tr>
                              <th>Inspection Date</th>
                              <th>Normal Hive Condition</th>
                              <th>Saw Queen</th>
                              <th>Queen marked</th>
                              <th>Eggs seen</th>
                              <th>Larva seen</th>
                              <th>Pupa seen</th>
                              <th>Drone cells</th>
                              <th>Queen cells</th>
                              <th>Hive beetles</th>
                              <th>Wax moth</th>
                              <th>Noseema</th>
                              <th>Mite wash</th>
                              <th>Mite count</th>
                              <th>Temperment</th>
                              <th>Population</th>
                              <th>Solid uniform frames</th>
                              <th>Slightly potty frames</th>
                              <th>Spotty frames</th>
                              <th>Normal odor</th>
                              <th>Brood</th>
                              <th>Honey</th>
                              <th>Pollen</th>
                              <th>Frames of bees</th>
                              <th>Frames of brood</th>
                              <th>Frames of honey</th>
                              <th>Frames of pollen</th>
                              <th>Honey supers</th>
                              <th>Add supers</th>
                              <th>Weigh super 3</th>
                              <th>Weigh super 2</th>
                              <th>Weigh super 1</th>
                              <th>Weigh brood 3</th>
                              <th>Weigh brood 2</th>
                              <th>Weigh brood 1</th>
                              <th>Prep for extraction</th>
                              <th>Feed hive what</th>
                              <th>Install medication what</th>
                              <th>Medication Reminder</th>
                              <th>Remove medication</th>
                              <th>Split hive</th>
                              <th>Re queen</th>
                              <th>Swap brood boxes</th>
                              <th>Insulate winterize</th>
                          </tr>
                      </thead>
                      <tbody>

                          @foreach($inspectionlist as $key => $inspection)
                              <tr>
                                  <td>
                                      <span class="text-center">{{$inspection->inspection_date}}</span>
                                  </td>
                                  <td>
                                      @if($inspection->normal_hive_condition == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->normal_hive_condition == '0')
                                      <span class="color-red"> No </span>
                                      @endif
                                  </td>

                                  <td class="text-primary">
                                      @if($inspection->saw_queen == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->saw_queen == '0')
                                      <span class="color-yellow"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->queen_marked == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->queen_marked == '0')
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->eggs_seen == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->eggs_seen == '0')
                                      <span class="color-yellow"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->larva_seen == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->larva_seen == '0')
                                      <span class="color-yellow"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->pupa_seen == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->pupa_seen == '0')
                                      <span class="color-yellow"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->drone_cells == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->drone_cells == '0')
                                      <span class="color-yellow"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->queen_cells == '1')
                                      <span class="color-yellow"> Yes </span>
                                      @elseif($inspection->queen_cells == '0')
                                      <span class="color-green"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->hive_beetles == '1')
                                      <span class="color-red"> Yes </span>
                                      @elseif($inspection->hive_beetles == '0')
                                      <span class="color-green"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->wax_moth == '1')
                                      <span class="color-red"> Yes </span>
                                      @elseif($inspection->wax_moth == '0')
                                      <span class="color-green"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->noseema == '1')
                                      <span class="color-red"> Yes </span>
                                      @elseif($inspection->noseema == '0')
                                      <span class="color-green"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->mite_wash == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->mite_wash == '0')
                                      <span class="color-yellow"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                  <span class="text-center">{{$inspection->mite_count}}</span></td>


                                  <td class="text-primary">
                                      @if($inspection->temperment == 'Calm')
                                      <span class="color-green"> {{$inspection->temperment}} </span>
                                      @elseif($inspection->temperment == 'Nervous')
                                      <span class="color-yellow"> {{$inspection->temperment}} </span>
                                      @elseif($inspection->temperment == 'Aggressive')
                                      <span class="color-red"> {{$inspection->temperment}} </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->population == 'Heavy')
                                      <span class="color-yellow"> {{$inspection->population}} </span>
                                      @elseif($inspection->population == 'Moderate')
                                      <span class="color-green"> {{$inspection->population}} </span>
                                      @elseif($inspection->population == 'Low')
                                      <span class="color-red"> {{$inspection->population}} </span>
                                      @endif
                                  </td>

                                  <td class="text-primary">
                                      @if($inspection->solid_uniform_frames)
                                      <span class="text-center">{{$inspection->solid_uniform_frames}}</span>
                                      @else
                                      <span class="text-center">No</span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->slightly_spotty_frames)
                                      <span class="text-center">{{$inspection->slightly_spotty_frames}}</span>
                                      @else
                                      <span class="text-center">No</span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->spotty_frames == '1')
                                      <span class="color-red"> Yes </span>
                                      @elseif($inspection->spotty_frames == '0')
                                      <span class="color-green"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->normal_odor == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->normal_odor == '0')
                                      <span class="color-red"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->brood == 'Heavy')
                                      <span class="color-yellow"> {{$inspection->brood}} </span>
                                      @elseif($inspection->brood == 'Moderate')
                                      <span class="color-green"> {{$inspection->brood}} </span>
                                      @elseif($inspection->brood == 'Low')
                                      <span class="color-red"> {{$inspection->brood}} </span>
                                      @endif
                                      </td>


                                  <td class="text-primary">
                                      @if($inspection->honey == 'Heavy')
                                      <span class="color-yellow"> {{$inspection->honey}} </span>
                                      @elseif($inspection->honey == 'Moderate')
                                      <span class="color-gray"> {{$inspection->honey}} </span>
                                      @elseif($inspection->honey == 'Low')
                                      <span class="color-red"> {{$inspection->honey}} </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->pollen == 'Heavy')
                                      <span class="color-yellow"> {{$inspection->pollen}} </span>
                                      @elseif($inspection->pollen == 'Moderate')
                                      <span class="color-green"> {{$inspection->pollen}} </span>
                                      @elseif($inspection->pollen == 'Low')
                                      <span class="color-red"> {{$inspection->pollen}} </span>
                                      @endif
                                      </td>


                                  <td class="text-primary">
                                      @if($inspection->frames_of_bees)
                                          <span class="text-center">{{$inspection->frames_of_bees}}</span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->frames_of_brood)
                                      <span class="text-center">{{$inspection->frames_of_brood}}</span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->frames_of_honey)
                                         <span class="text-center">{{$inspection->frames_of_honey}}</span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->frames_of_pollen)
                                          <span class="text-center">{{$inspection->frames_of_pollen}}</span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->honey_supers)
                                      <span class="color-green"> {{$inspection->honey_supers}} </span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->add_supers)
                                      <span class="color-green">  {{$inspection->add_supers}}</span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->weigh_super_3)
                                      <span class="color-green">  {{$inspection->weigh_super_3}}</span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->weigh_super_2)
                                      <span class="color-green">  {{$inspection->weigh_super_2}}</span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->weigh_super_1)
                                      <span class="color-green"> {{$inspection->weigh_super_1}}</span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->weigh_brood_3)
                                      <span class="color-green">  {{$inspection->weigh_brood_3}}</span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->weigh_brood_2)
                                      <span class="color-green">  {{$inspection->weigh_brood_2}}</span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->weigh_brood_1)
                                      <span class="color-green">  {{$inspection->weigh_brood_1}}</span>
                                      @else
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->prep_for_extraction == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->prep_for_extraction == '0')
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->feed_hive_what)
                                      <span class="text-center"> {{$inspection->feed_hive_what}}</span>
                                      @else
                                      <span class="text-center">-</span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->install_medication_what == 'Formic')
                                      <span class="color-yellow"> {{$inspection->install_medication_what}} </span>
                                      @elseif($inspection->install_medication_what == 'Apivar')
                                      <span class="color-yellow"> {{$inspection->install_medication_what}} </span>
                                      @elseif($inspection->install_medication_what == 'Other')
                                      <span class="color-yellow"> {{$inspection->install_medication_what}} </span>
                                      @endif
                                  </td>



                                  <td class="text-primary">
                                      <span class="text-center"> {{$inspection->medication_reminder}} </span>
                                  </td>



                                  <td class="text-primary">
                                      @if($inspection->remove_medication == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->remove_medication == '0')
                                      <span class="color-yellow"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->split_hive == '1')
                                      <span class="color-yellow"> Yes </span>
                                      @elseif($inspection->split_hive == '0')
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->re_queen == '1')
                                      <span class="color-green"> Yes </span>
                                      @elseif($inspection->re_queen == '0')
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->swap_brood_boxes == '1')
                                      <span class="color-gray"> Yes </span>
                                      @elseif($inspection->swap_brood_boxes == '0')
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                                  <td class="text-primary">
                                      @if($inspection->insulate_winterize == '1')
                                      <span class="color-gray"> Yes </span>
                                      @elseif($inspection->insulate_winterize == '0')
                                      <span class="color-gray"> No </span>
                                      @endif
                                  </td>


                              </tr>
                          @endforeach
                      </tbody>
                      </table>
                    </div>

                    @else
                    <h4>No inspection Found.</h4>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="{{ URL::asset('/public/css/datatables.css')}}">
<link rel="stylesheet" href="{{ URL::asset('/public/css/datatables.min.css')}}">
<script src="{{ URL::asset('/public/js/datatables.js')}}"></script>
<script src="{{ URL::asset('/public/js/datatables.min.js')}}"></script>


@section('script')
    @if(Session::has('message'))
        <script>
        $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
        </script>
    @endif


<script>
	$(document).ready(function () {
        new DataTable('#inspectionTable', {
            scrollX: true
        });
    });

    var SITE_URL = "<?php echo URL::to('/'); ?>";
    $(document.body).on('click', ".sendReportButton", function(){
      document.getElementById("sendReportButton").disabled = true;
      $("#sendReportButton").html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
    });

</script>

@endsection
