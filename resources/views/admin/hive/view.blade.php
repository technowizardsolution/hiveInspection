@extends('admin.layouts.app')
@section('title')  Hive Details | @endsection
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Hive Details</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Hive Details
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
                                <h4 class="card-title">Hive Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-user-information">
                                      <tbody>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td class="text-primary">{{$hive->user->email}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hive Name</strong></td>
                                            <td class="text-primary">@if($hive->hive_name){{$hive->hive_name}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Location</strong></td>
                                            <td class="text-primary">@if($hive->location){{$hive->location}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Build Date</strong></td>
                                            <td class="text-primary">@if($hive->build_date){{$hive->build_date}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Origin</strong></td>
                                            <td class="text-primary">@if($hive->origin){{$hive->origin}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Deeps</strong></td>
                                            <td class="text-primary">@if($hive->deeps){{$hive->deeps}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mediums</strong></td>
                                            <td class="text-primary">@if($hive->mediums){{$hive->mediums}}@endif</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Queen introduced</strong></td>
                                            <td class="text-primary">@if($hive->queen_introduced){{$hive->queen_introduced}}@endif</td>
                                        </tr>                                        
                                        
                                      </tbody>
                                    </table>
                                    <div class="col-sm-12">
                                        <div class="" style="border-top:0">
                                            <div class="box-footer">
                                                <a type="" href="{{url('/admin/hive')}}" id="cancelBtn" class="btn btn-primary pull-right">
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
