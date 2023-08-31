<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\DataTables\Admin\HiveDataTable;
use App\Device;
use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\User;
use App\Hive;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Str;
use Validator;
use Yajra\DataTables\Html\Builder;
use \Softon\LaravelFaceDetect\Facades\FaceDetect;
use Crypt;
use Google2FA;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;

class HiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hive-list|hive-delete', ['only' => ['index', 'store']]);        
        $this->middleware('permission:hive-delete', ['only' => ['destroy']]);

        // Validator::extend('unique_role_name', function ($attribute, $value, $parameters) {
        //     $arr = explode("*_*",$parameters[0]);
        //     $name = $arr[0];
        //     $id = $arr[1];
        //     $userDetail = Role::where('id','<>',$id)->where('name',$name)->first();
        //     return $userDetail ? false : true;
        // });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, HiveDataTable $dataTable,Request $request)
    {
        $html = $builder->columns([
            ['data' => 'hive_id', 'name' => 'hive_id', 'title' => 'ID'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'hive_name', 'name' => 'hive_name', 'title' => 'Hive Name'],            
            ['data' => 'location', 'name' => 'location', 'title' => 'Location'],            
            ['data' => 'build_date', 'name' => 'build_date', 'title' => 'Build Date'],            
            ['data' => 'origin', 'name' => 'origin', 'title' => 'Origin'],            
            ['data' => 'deeps', 'name' => 'deeps', 'title' => 'Deeps'],            
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],            
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'title' => 'Action'],
        ])->parameters([
            'order' => [0, 'desc'],
            'responsive' => true,
            'scrollX' => true,
            'responsive' => true,
        ]);

        if(request()->ajax()) {
            $hive = Hive::with('user');
            return $dataTable->dataTable($hive)->toJson();
        }
        $users = User::where('user_status','1')->whereHas("roles", function($q){ $q->where("id","=","2"); });
        return view('admin.hive.list', compact('html','users'));
    }

    public function create()
    {
        $users = User::where('user_status','1')->whereHas("roles", function($q){ $q->where("id","=","2"); })->get();        
        return View('admin.hive.create',compact('users'));
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $hive->user_id = $request['user_id'];
        if ($hive->save()) {            
            Session::flash('message', 'Hive added succesfully !');
            Session::flash('alert-class', 'success');
            return redirect('admin/hive');

        } else {
            Session::flash('message', 'Oops !! Something went wrong!');
            Session::flash('alert-class', 'error');
            return redirect('admin/hive');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hive = Hive::find($id);
        if (!empty($hive)) {
            return view('admin.hive.view')->with(compact('hive'));
        } else {
            Session::flash('message', 'Hive not found!');
            Session::flash('alert-class', 'error');
            return redirect('admin/hive');
        }
    }  
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::where('user_status','1')->whereHas("roles", function($q){ $q->where("id","=","2"); })->get();
        $hivedata = Hive::find($id);
        if(!empty($hivedata)){            
            return view('admin.hive.edit')->with(compact('hivedata','users'));
        }
        else{
            Session::flash('message', 'Hive not found!');
            Session::flash('alert-class', 'error');
            return redirect('admin/hive');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        } else {

            $hive = Hive::find($id);           
            $hive->hive_name = $request['hive_name'];
            $hive->location = $request['location'];
            $hive->build_date = $request['build_date'];
            $hive->origin = $request['origin'];
            $hive->deeps = $request['deeps'];
            $hive->mediums = $request['mediums'];
            $hive->queen_introduced = $request['queen_introduced'];                     
            $hive->updated_at = date("Y-m-d H:i:s");
            if ($hive->save()) {
                Session::flash('message', 'Hive Updated Succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('admin/hive');
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect('admin/hive');
            }
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
                return true;
            } else {
                return 'Something went to wrong';
            }

        }
    }
   


 

   

   

   

    
}
