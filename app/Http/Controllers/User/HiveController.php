<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Session;
use App\Hive;

class HiveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hivedata = Hive::where('user_id',$user->id)->first();        
        return view('user.hive.add',compact('user','hivedata'));
    }

    public function store(Request $request)
    {
        $rules = array(            
            'hive_name' => 'required'
        );
        $messages = [            
            'hive_name.required' => 'Please enter hive name.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        if($request['hive_id']){
            $hive = Hive::find($request['hive_id']);  
        }else{
            $hive = new Hive();  
        }
        $hive->hive_name = $request['hive_name'];
        $hive->location = $request['location'];
        $hive->build_date = $request['build_date'];
        $hive->origin = $request['origin'];
        $hive->deeps = $request['deeps'];
        $hive->mediums = $request['mediums'];
        $hive->queen_introduced = $request['queen_introduced'];
        $hive->user_id = $request->user()->id;     
        if ($hive->save()) {            
            Session::flash('message', 'Hive added succesfully !');
            Session::flash('alert-class', 'success');
            return redirect('user/inspection/'.$hive->hive_id);

        } else {
            Session::flash('message', 'Oops !! Something went wrong!');
            Session::flash('alert-class', 'error');
            return redirect('user/hive');
        }
    }
}
