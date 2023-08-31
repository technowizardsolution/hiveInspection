<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(1);
        return view('home');
    }

    public function pageLoad(Request $request)
    {
        return view('page-load');
    }

    function default(Request $request) {
        // dd(Auth::check());
        if (Auth::check()) {
            $rolename = \Auth::user()->roles->first()->name;
            if ($rolename == 'admin') {
                return redirect('admin/dashboard');
            } else if ($rolename == 'subadmin') {
                return redirect('subadmin/dashboard');
            } else if ($rolename == 'doctor') {
                return redirect('doctor/dashboard');
            } else if ($rolename == 'nurse') {
                return redirect('nurse/dashboard');
            } else if ($rolename == 'hospital') {
                return redirect('hospital/dashboard');
            } else if ($rolename == 'laboratory') {
                return redirect('laboratory/dashboard');
            } else if ($rolename == 'user') {
                return redirect('user/hive');
            } else {
                return redirect('admin/dashboard');
            }
        } else {
            return redirect('login');
        }
    }

    public function saveTheamMode(Request $request)
    {
        User::where('id', auth()->user()->id)->update(['theam_mode' => $request['theam_mode']]);
        return '1';
    }

}
