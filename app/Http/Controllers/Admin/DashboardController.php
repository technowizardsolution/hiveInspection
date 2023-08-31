<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function __invoke(Request $request)
    {
     $totalUser = User::whereHas("roles", function($q){ $q->where("name","!=","admin"); })->where('user_status','!=','-1')->count();
        return view('admin.dashboard',['totalUser' => $totalUser]);//' "Welcome to our homepage";
    }
    
  public function dashboardFilterData(Request $request){
    $date = explode('to',$request->date);
    if(isset($date[0]) && isset($date[1])){
        $start_date = date("Y-m-d H:i:s", strtotime($date[0]));
        $end_date = date("Y-m-d 23:59:59", strtotime($date[1]));
    }elseif(isset($date[0]) && $date[0]){
      $start_date = date("Y-m-d H:i:s", strtotime($date[0]));
      $end_date = date("Y-m-d 23:59:59", strtotime($date[0]));
    }else{
        $start_date = date("Y-m-d H:i:s",-1);
        $end_date = date("Y-m-d H:i:s");
    }

    // $start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
    // $end_date = date("Y-m-d 23:59:59", strtotime($request->end_date));
    $totalUser = User::whereHas("roles", function($q){ $q->where("name", "user"); })
                      ->where('users.created_at','>=',$start_date)
                      ->where('users.created_at','<=',$end_date)
                      ->count();
    $totalSubadmin = User::whereHas("roles", function($q){ $q->where("name", "subadmin"); })
                      ->where('users.created_at','>=',$start_date)
                      ->where('users.created_at','<=',$end_date)
                      ->count();
    $countInfo['totalUser'] = $totalUser;
    $countInfo['totalSubadmin'] = $totalSubadmin;
    return $countInfo;
  }
}
