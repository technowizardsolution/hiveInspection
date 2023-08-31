<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function userWelcome()
    {
        $user = Auth::user();
        return view('user.hive.add',compact('user'));        
    }
}
