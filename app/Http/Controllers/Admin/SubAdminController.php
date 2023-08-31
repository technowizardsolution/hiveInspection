<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\SubAdminDataTable;
use Yajra\DataTables\Html\Builder;
use App\Helper\GlobalHelper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Str;
use Session;
use Validator;
use App\User;
use DataTables;
use App\Chat;
use App\Country;
use App\State;
use App\City;
use Mail;
use Hash;

class SubAdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subadmin-list|subadmin-create|subadmin-edit|subadmin-delete|subadmin-status-change|subadmin-view', ['only' => ['index','store']]);
        $this->middleware('permission:subadmin-create', ['only' => ['create','store']]);
        $this->middleware('permission:subadmin-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subadmin-delete', ['only' => ['destroy']]);
        $this->middleware('permission:subadmin-status-change', ['only' => ['changeStatus']]);
        $this->middleware('permission:subadmin-view', ['only' => ['show']]);
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, SubAdminDataTable $dataTable)
    {
        $html = $builder->columns([
            ['data' => 'id', 'name' => 'id','title' => 'ID'],
            ['data' => 'first_name', 'name' => 'first_name','title' => 'Name'],
            ['data' => 'email', 'name' => 'email','title' => 'Email'],
            ['data' => 'status', 'name' => 'status','title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at','title' => 'Scaned At'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false,'title' => 'Action'],
        ])->parameters([
            'order' => [0,'desc'],
            'scrollX' => true,
            'responsive' => true,
        ]);
        if(request()->ajax()) {
            $users = User::whereHas("roles", function($q){ $q->where("id","=","3"); });
            return $dataTable->dataTable($users)->toJson();
        }
        return view('admin.subadmins.list',compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::where("status","1")->get();

        return View('admin.subadmins.create',compact("countries"));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,id'
        );
        $messages = [
            'name.required' => 'Please enter name.',
            'mobile_number.required' => 'Please enter mobile number.',
            'mobile_number.numeric' =>'Please enter at least 10 -15 digits.' ,
            'mobile_number.unique' =>'Please enter another mobile number.',
            'email.required' =>'Please enter email.',
            'email.unique' => 'Provided email is already registered with us.',
            'password.required' => 'Password should contain number,characters,special character and atleast one capital letter.',
            'confirm_password.required' => 'Please enter same as password',
            'country.required'=>'Please select country.',
            'state.required'=>'Please select state.',
            'city.required'=>'Please select city.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        //dd($validator->fails());
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $password = GlobalHelper::randomPasswordStrongPassword();
            $adminUser = new User();
            $adminUser->first_name = $request['name'];
            $adminUser->email = $request['email'];
            $adminUser->user_status = '1';
            $adminUser->password = Hash::make($password);
            $adminUser->created_by = Auth::user()->id;

            }
            if(!empty($request->main_image) || $request->main_image != ''){
                $data = explode(';', $request->main_image);
                $part = explode("/", $data[0]);
                $image = $request->main_image;  // your base64 encoded
                $image = str_replace('data:image/'.$part[1].';base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $fileName = md5(microtime().Str::random(10)) .'.'.$part[1];
                $destinationPath = base_path().'/resources/uploads/profile/';
                \File::put(base_path().'/resources/uploads/profile/' .$fileName, base64_decode($image));
                chmod($destinationPath.$fileName,0777);
                $adminUser->profile_picture = $fileName;
                $image = url('/').'/resources/uploads/profile/'.$fileName;

            }else{
                $image='';
            }

            if ($adminUser->save()) {

                $adminUser->assignRole(3);
                Mail::send('emails.sendcredential', ['user' => $adminUser,'password'=>$password,'email'=>$adminUser->email,'name'=>$adminUser->name], function ($m) use ($adminUser) {
                  $m->to($adminUser->email, $adminUser->name)->subject('Login credential');
                });
                Session::flash('message', 'Sub Admin Added Succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('admin/subadmins');

            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect('admin/subadmins');
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
        $user = User::with('countyData','stateData','cityData')->find($id);
        if(!empty($user)){

            return view('admin.subadmins.view')->with(compact('user'));
        }
        else{
            Session::flash('message', 'Sub Admin not found!');
            Session::flash('alert-class', 'error');
            return redirect('admin/subadmins');
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
        $user = User::find($id);
        if(!empty($user)){
             $getCountry = Country::where("status","1")->get();
            $getCity = City::where("state_id",$user->state)->get();
            $getState = State::where("country_id",$user->country)->get();
            return view('admin.subadmins.edit')->with(compact('user','getCountry','getState','getCity'));
        }
        else{
            Session::flash('message', 'Sub Admin not found!');
            Session::flash('alert-class', 'error');
            return redirect('admin/subadmins');
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
                //dd($id);
         $rules = array(
            //'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
            );
                $messages = [
                    'name.required' => 'Please enter name.',
                    'mobile_number.required' => 'Please enter mobile number.',
                    'mobile_number.numeric' =>'Please enter at least 10 -15 digits.' ,
                    'mobile_number.unique' =>'Please enter another mobile number.',
                    'email.required' =>'Please enter email.',
                    'email.unique' => 'Provided email is already registered with us.',
                    'country.required'=>'Please select country.',
                    'state.required'=>'Please select state.',
                    'city.required'=>'Please select city.',
                ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $adminUser = User::find($id);
            $adminUser->first_name = $request['name'];
            $adminUser->email = $request['email'];
            $adminUser->created_by = Auth::user()->id;
            if($request['password']!= null || !empty($request['password'])){
                $adminUser->password = bcrypt($request['password']);
            }
            if(!empty($request->main_image) || $request->main_image != ''){
                if($adminUser->profile_picture && file_exists(base_path().'/resources/uploads/profile/'.$adminUser->profile_picture)){
                  unlink(base_path().'/resources/uploads/profile/'.$adminUser->profile_picture); // correct
                }
                $data = explode(';', $request->main_image);
                $part = explode("/", $data[0]);
                $image = $request->main_image;  // your base64 encoded
                $image = str_replace('data:image/'.$part[1].';base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $fileName = md5(microtime().Str::random(10)) .'.'.$part[1];
                $destinationPath = base_path().'/resources/uploads/profile/';
                \File::put(base_path().'/resources/uploads/profile/' .$fileName, base64_decode($image));
                chmod($destinationPath.$fileName,0777);
                $adminUser->profile_picture = $fileName;
                $image = url('/').'/resources/uploads/profile/'.$fileName;

            }else{
                $image='';
            }

            $adminUser->updated_at = date("Y-m-d H:i:s");
            if ($adminUser->save()) {

                Session::flash('message', 'Sub Admin Updated Succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('admin/subadmins');
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect('admin/subadmins');
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
        if(isset($id)){
            // $user = User::find($id);
            if($id==1)
                return "You can't delete Super Admin";
            $user = User::with('roles')->find($id);
            $role = (isset($user->roles)&& count($user->roles))?$user->roles[0]->id:'';
            if($user->delete())
            {
                if($role){
                    $user->removeRole($role);
                }
                 return true;
            }
             else
                return 'Something went to wrong';

        }
    }
    public function changeStatus(Request $request)
    {
        return $this->UpdateStatus($request->id,User::class,'user_status');

    }
}
