@extends('admin.layouts.app')
@section('title')  Inspection Details | @endsection
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
  
</style>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Inspection Details</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Inspection Details
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="bs-validation">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Inspection Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-user-information">
                                      <tbody>
                                        <tr>
                                            <td><strong>Inspection date</strong></td>
                                            <td class="text-primary">{{$inspection->inspection_date}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Normal Hive Condition</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->normal_hive_condition == '1')
                                                <span class="color-green"> Yes </span>
                                              @elseif($inspection->normal_hive_condition == '0')
                                                <span class="color-red"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Saw Queen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->saw_queen == '1')
                                                <span class="color-green"> Yes </span>
                                              @elseif($inspection->saw_queen == '0')
                                                <span class="color-yellow"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Queen marked</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->queen_marked == '1')
                                                <span class="color-green"> Yes </span>
                                              @elseif($inspection->queen_marked == '0')
                                                <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Eggs seen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->eggs_seen == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->eggs_seen == '0')
                                              <span class="color-yellow"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Larva seen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->larva_seen == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->larva_seen == '0')
                                              <span class="color-yellow"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pupa seen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->pupa_seen == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->pupa_seen == '0')
                                              <span class="color-yellow"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Drone cells</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->drone_cells == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->drone_cells == '0')
                                              <span class="color-yellow"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Queen cells</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->queen_cells == '1')
                                              <span class="color-yellow"> Yes </span>
                                              @elseif($inspection->queen_cells == '0')
                                              <span class="color-green"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hive beetles</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->hive_beetles == '1')
                                              <span class="color-red"> Yes </span>
                                              @elseif($inspection->hive_beetles == '0')
                                              <span class="color-green"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Wax moth</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->wax_moth == '1')
                                              <span class="color-red"> Yes </span>
                                              @elseif($inspection->wax_moth == '0')
                                              <span class="color-green"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Noseema</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->noseema == '1')
                                              <span class="color-red"> Yes </span>
                                              @elseif($inspection->noseema == '0')
                                              <span class="color-green"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mite wash</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->mite_wash == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->mite_wash == '0')
                                              <span class="color-yellow"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mite count</strong></td>
                                            <td class="text-primary">{{$inspection->mite_count}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Temperment</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->temperment == 'Calm')
                                              <span class="color-green"> {{$inspection->temperment}} </span>
                                              @elseif($inspection->temperment == 'Nervous')
                                              <span class="color-yellow"> {{$inspection->temperment}} </span>
                                              @elseif($inspection->temperment == 'Aggressive')
                                              <span class="color-red"> {{$inspection->temperment}} </span>
                                              @endif                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Population</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->population == 'Heavy')
                                              <span class="color-yellow"> {{$inspection->population}} </span>
                                              @elseif($inspection->population == 'Moderate')
                                              <span class="color-green"> {{$inspection->population}} </span>
                                              @elseif($inspection->population == 'Low')
                                              <span class="color-red"> {{$inspection->population}} </span>
                                              @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>Laying Pattern</strong></td>            
                                            <td class="text-primary">&nbsp;</td>                                
                                        </tr>

                                        <tr>
                                            <td><strong>Solid uniform frames</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->solid_uniform_frames)
                                                {{$inspection->solid_uniform_frames}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Slightly potty frames</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->slightly_spotty_frames)
                                                {{$inspection->slightly_spotty_frames}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Spotty frames</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->spotty_frames == '1')
                                              <span class="color-red"> Yes </span>
                                              @elseif($inspection->spotty_frames == '0')
                                              <span class="color-green"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Normal odor</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->normal_odor == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->normal_odor == '0')
                                              <span class="color-red"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Brood</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->brood == 'Heavy')
                                              <span class="color-yellow"> {{$inspection->brood}} </span>
                                              @elseif($inspection->brood == 'Moderate')
                                              <span class="color-green"> {{$inspection->brood}} </span>
                                              @elseif($inspection->brood == 'Low')
                                              <span class="color-red"> {{$inspection->brood}} </span>
                                              @endif
                                              </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Honey</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->honey == 'Heavy')
                                              <span class="color-yellow"> {{$inspection->honey}} </span>
                                              @elseif($inspection->honey == 'Moderate')
                                              <span class="color-gray"> {{$inspection->honey}} </span>
                                              @elseif($inspection->honey == 'Low')
                                              <span class="color-red"> {{$inspection->honey}} </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pollen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->pollen == 'Heavy')
                                              <span class="color-yellow"> {{$inspection->pollen}} </span>
                                              @elseif($inspection->pollen == 'Moderate')
                                              <span class="color-green"> {{$inspection->pollen}} </span>
                                              @elseif($inspection->pollen == 'Low')
                                              <span class="color-red"> {{$inspection->pollen}} </span>
                                              @endif
                                              </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Frames of bees</strong></td>
                                            <td class="text-primary">@if($inspection->frames_of_bees){{$inspection->frames_of_bees}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Frames of brood</strong></td>
                                            <td class="text-primary">@if($inspection->frames_of_brood){{$inspection->frames_of_brood}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Frames of honey</strong></td>
                                            <td class="text-primary">@if($inspection->frames_of_honey){{$inspection->frames_of_honey}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Frames of pollen</strong></td>
                                            <td class="text-primary">@if($inspection->frames_of_pollen){{$inspection->frames_of_pollen}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Honey supers</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->honey_supers)
                                              <span class="color-green"> {{$inspection->honey_supers}} </span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Add supers</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->add_supers)
                                              <span class="color-green">  {{$inspection->add_supers}}</span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh super 3</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_super_3)
                                              <span class="color-green">  {{$inspection->weigh_super_3}}</span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh super 2</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_super_2)
                                              <span class="color-green">  {{$inspection->weigh_super_2}}</span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh super 1</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_super_1)
                                              <span class="color-green"> {{$inspection->weigh_super_1}}</span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh brood 3</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_brood_3)
                                              <span class="color-green">  {{$inspection->weigh_brood_3}}</span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh brood 2</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_brood_2)
                                              <span class="color-green">  {{$inspection->weigh_brood_2}}</span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh brood 1</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_brood_1)
                                              <span class="color-green">  {{$inspection->weigh_brood_1}}</span>
                                              @else
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Prep for extraction</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->prep_for_extraction == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->prep_for_extraction == '0')
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Feed hive what</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->feed_hive_what)
                                                {{$inspection->feed_hive_what}}
                                              @else
                                                -
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Install medication what</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->install_medication_what == 'Formic')
                                              <span class="color-yellow"> {{$inspection->install_medication_what}} </span>
                                              @elseif($inspection->install_medication_what == 'Apivar')
                                              <span class="color-yellow"> {{$inspection->install_medication_what}} </span>
                                              @elseif($inspection->install_medication_what == 'Other')
                                              <span class="color-yellow"> {{$inspection->install_medication_what}} </span>
                                              @endif                                              
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>Medication Reminder</strong></td>
                                            <td class="text-primary">
                                               <span> {{$inspection->medication_reminder}} </span>                                             
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>Remove medication</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->remove_medication == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->remove_medication == '0')
                                              <span class="color-yellow"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Split hive</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->split_hive == '1')
                                              <span class="color-yellow"> Yes </span>
                                              @elseif($inspection->split_hive == '0')
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Re queen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->re_queen == '1')
                                              <span class="color-green"> Yes </span>
                                              @elseif($inspection->re_queen == '0')
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Swap brood boxes</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->swap_brood_boxes == '1')
                                              <span class="color-gray"> Yes </span>
                                              @elseif($inspection->swap_brood_boxes == '0')
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Insulate winterize</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->insulate_winterize == '1')
                                              <span class="color-gray"> Yes </span>
                                              @elseif($inspection->insulate_winterize == '0')
                                              <span class="color-gray"> No </span>
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Additional notes</strong></td>
                                            <td class="text-primary">@if($inspection->additional_notes){{$inspection->additional_notes}}@endif</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <div class="col-sm-12">
                                        <div style="border-top:0">
                                            <div class="box-footer">
                                                <a href="{{url('/admin/inspection')}}" id="cancelBtn" class="btn btn-primary pull-right">
                                                  Back
                                                </a>
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
