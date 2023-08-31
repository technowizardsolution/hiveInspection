@extends('admin.layouts.app')
@section('title')  Role Detail | @endsection
@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">User Details</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="{{url('admin/dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">User Details
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
                                <h4 class="card-title">User Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                     <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td class="text-primary">{{ $role->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Permissions</strong></td>
                                                <td class="text-primary">
                                                    @if(count($rolePermissions))
                                                        @foreach($rolePermissions->groupBy('category') as $value)
                                                            @if(count($value))
                                                                <div class="categoryDiv">
                                                                    <p class="categoryHeader">{{$value[0]->category}}</p>
                                                                </div>
                                                                @foreach($value as $data)
                                                                    <label class="label label-success">{{ $data->name }},</label>
                                                                @endforeach
                                                            @endif
                                                            <br  />
                                                            @endforeach
                                                        {{-- @foreach($rolePermissions as $v)
                                                            <div class="categoryDiv">
                                                                <p class="categoryHeader">{{$v->category}}</p>
                                                            </div>
                                                            <label class="label label-success">{{ $v->name }},</label>
                                                        @endforeach --}}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12">
                                        <div class="" style="border-top:0">
                                            <div class="box-footer">
                                                <a type="" href="{{url('/admin/roles')}}" id="cancelBtn" class="btn btn-primary pull-right">
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

@section('css')
<style>
    .permission_section label{
        font-weight:500;
    }
    .categoryDiv{
        margin-top: 10px;
        background: #f7f7f7;
    }
    .categoryHeader{
        font-size: 17px;
    }
    .selectOnlyCategory {
        margin: 0 20px;
        font-size: 16px;
        text-transform: lowercase;
    }
    .roles-name{
        font-size: 12px;
    }
</style>
@endsection
