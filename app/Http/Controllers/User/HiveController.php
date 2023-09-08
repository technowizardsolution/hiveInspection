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
        $records = Hive::where('user_id',$user->id)->orderBy('hive_id','desc')->paginate(10);        
        return view('user.hive.view', compact('records','user'));
    }

    public function add()
    {
        $user = Auth::user();        
        return view('user.hive.add',compact('user'));
    }

    public function edit($id)
    {
        $hivedata = Hive::find($id);
        if(!empty($hivedata)){            
            return view('user.hive.edit')->with(compact('hivedata'));
        }
        else{
            Session::flash('message', 'Hive not found!');
            Session::flash('alert-class', 'error');
            return redirect('user/hive');
        }
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

    public function update(Request $request)
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
            $hive->hive_name = $request['hive_name'];
            $hive->location = $request['location'];
            $hive->build_date = $request['build_date'];
            $hive->origin = $request['origin'];
            $hive->deeps = $request['deeps'];
            $hive->mediums = $request['mediums'];
            $hive->queen_introduced = $request['queen_introduced'];
            $hive->user_id = $request->user()->id;     
            if ($hive->save()) {            
                Session::flash('message', 'Hive updated succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('user/hive');

            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect('user/hive');
            }
        }else{
            Session::flash('message', 'Oops !! Something went wrong!');
            Session::flash('alert-class', 'error');
            return redirect('user/hive');
        }
        
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (isset($id)) {            
            $hive = Hive::find($id);            
            if ($hive->delete()) {                              
                Session::flash('message', 'Hive deleted succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('user/hive');
            } else {
                return 'Something went to wrong';
            }

        }
    }

    
}
