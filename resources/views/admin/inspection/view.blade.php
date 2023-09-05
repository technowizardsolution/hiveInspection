@extends('admin.layouts.app')
@section('title')  Inspection Details | @endsection
@section('content')
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
                                            <td><strong>hive_date</strong></td>
                                            <td class="text-primary">{{$inspection->hive_date}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Normal Hive Condition</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->normal_hive_condition == '1')
                                                Yes
                                              @elseif($inspection->normal_hive_condition == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Saw Queen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->saw_queen == '1')
                                                Yes
                                              @elseif($inspection->saw_queen == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Queen marked</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->queen_marked == '1')
                                                Yes
                                              @elseif($inspection->queen_marked == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Eggs seen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->eggs_seen == '1')
                                                Yes
                                              @elseif($inspection->eggs_seen == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Larva seen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->larva_seen == '1')
                                                Yes
                                              @elseif($inspection->larva_seen == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pupa seen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->pupa_seen == '1')
                                                Yes
                                              @elseif($inspection->pupa_seen == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Drone cells</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->drone_cells == '1')
                                                Yes
                                              @elseif($inspection->drone_cells == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Queen cells</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->queen_cells == '1')
                                                Yes
                                              @elseif($inspection->queen_cells == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hive beetles</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->hive_beetles == '1')
                                                Yes
                                              @elseif($inspection->hive_beetles == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Wax moth</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->wax_moth == '1')
                                                Yes
                                              @elseif($inspection->wax_moth == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Noseema</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->noseema == '1')
                                                Yes
                                              @elseif($inspection->noseema == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mite wash</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->mite_wash == '1')
                                                Yes
                                              @elseif($inspection->mite_wash == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mite count</strong></td>
                                            <td class="text-primary">{{$inspection->mite_count}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Temperment</strong></td>
                                            <td class="text-primary">{{$inspection->temperment}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Population</strong></td>
                                            <td class="text-primary">{{$inspection->population}}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Laying Pattern</strong></td>            
                                            <td class="text-primary">&nbsp;</td>                                
                                        </tr>

                                        <tr>
                                            <td><strong>Solid uniform frames</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->solid_uniform_frames == '1')
                                                {{$inspection->solid_uniform_frames}}
                                              @elseif($inspection->solid_uniform_frames == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Slightly potty frames</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->slightly_spotty_frames == '1')
                                                {{$inspection->slightly_spotty_frames}}
                                              @elseif($inspection->slightly_spotty_frames == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Spotty frames</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->spotty_frames == '1')
                                                Yes
                                              @elseif($inspection->spotty_frames == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Normal odor</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->normal_odor == '1')
                                                Yes
                                              @elseif($inspection->normal_odor == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Brood</strong></td>
                                            <td class="text-primary">@if($inspection->brood){{$inspection->brood}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Honey</strong></td>
                                            <td class="text-primary">@if($inspection->honey){{$inspection->honey}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pollen</strong></td>
                                            <td class="text-primary">@if($inspection->pollen){{$inspection->pollen}}@endif</td>
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
                                                {{$inspection->honey_supers}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Add supers</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->add_supers)
                                                {{$inspection->add_supers}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh super 3</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_super_3)
                                                {{$inspection->weigh_super_3}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh super 2</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_super_2)
                                                {{$inspection->weigh_super_2}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh super 1</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_super_1)
                                                {{$inspection->weigh_super_1}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh brood 3</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_brood_3)
                                                {{$inspection->weigh_brood_3}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh brood 2</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_brood_2)
                                                {{$inspection->weigh_brood_2}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Weigh brood 1</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->weigh_brood_1)
                                                {{$inspection->weigh_brood_1}}
                                              @else
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Prep for extraction</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->prep_for_extraction == '1')
                                                Yes
                                              @elseif($inspection->prep_for_extraction == '0')
                                                No
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
                                              @if($inspection->install_medication_what)
                                                {{$inspection->install_medication_what}}
                                              @else
                                                -
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Remove medication</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->remove_medication == '1')
                                                Yes
                                              @elseif($inspection->remove_medication == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Split hive</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->split_hive == '1')
                                                Yes
                                              @elseif($inspection->split_hive == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Re queen</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->re_queen == '1')
                                                Yes
                                              @elseif($inspection->re_queen == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Swap brood boxes</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->swap_brood_boxes == '1')
                                                Yes
                                              @elseif($inspection->swap_brood_boxes == '0')
                                                No
                                              @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Insulate winterize</strong></td>
                                            <td class="text-primary">
                                              @if($inspection->insulate_winterize == '1')
                                                Yes
                                              @elseif($inspection->insulate_winterize == '0')
                                                No
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
                                        <div class="" style="border-top:0">
                                            <div class="box-footer">
                                                <a type="" href="{{url('/admin/inspection')}}" id="cancelBtn" class="btn btn-primary pull-right">
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
