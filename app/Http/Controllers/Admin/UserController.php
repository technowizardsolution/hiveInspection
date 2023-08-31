<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\DataTables\Admin\UserDataTable;
use App\Device;
use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\User;
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

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

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
    public function index(Builder $builder, UserDataTable $dataTable,Request $request)
    {
        $html = $builder->columns([
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            // ['data' => 'first_name', 'name' => 'first_name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            // ['data' => 'mobile_number', 'name' => 'mobile_number', 'title' => 'Mobile Number'],
            // ['data' => 'dob', 'name' => 'dob', 'title' => 'Date of Birth'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Scaned At'],
            ['data' => 'last_login_at', 'name' => 'last_login_at', 'title' => 'Last Login At'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'title' => 'Action'],
        ])->parameters([
            'order' => [0, 'desc'],
            'responsive' => true,
            'scrollX' => true,
            'responsive' => true,
        ]);

        if(request()->ajax()) {
            $users = User::whereHas("roles", function($q){ $q->where("id","=","2"); });
            return $dataTable->dataTable($users)->toJson();
        }
        return view('admin.users.list', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.users.create');
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
            'email' => 'required|email|unique:users'
        );
        $messages = [            
            'email.required' => 'Please enter email.',
            'email.unique' => 'Provided email is already registered with us.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $password = GlobalHelper::randomPasswordStrongPassword();
        $adminUser = new User();        
        $adminUser->email = $request['email'];        
        $adminUser->user_status = '1';
        $adminUser->password = Hash::make($password);
        $adminUser->created_by = Auth::user()->id;
        $adminUser->email_verified = '1';
        $adminUser->email_verified_at = date("Y-m-d H:i:s");        
        if ($adminUser->save()) {
            $adminUser->assignRole(2);
            Mail::send('emails.sendcredential', ['user' => $adminUser,'password'=>$password,'email'=>$adminUser->email], function ($m) use ($adminUser) {
                $m->to($adminUser->email, '')->subject('Login credential');
            });
            Session::flash('message', 'User added succesfully !');
            Session::flash('alert-class', 'success');
            return redirect('admin/users');

        } else {
            Session::flash('message', 'Oops !! Something went wrong!');
            Session::flash('alert-class', 'error');
            return redirect('admin/users');
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
        $user = User::find($id);
        if (!empty($user)) {
            return view('admin.users.view')->with(compact('user'));
        } else {
            Session::flash('message', 'User not found!');
            Session::flash('alert-class', 'error');
            return redirect('admin/users');
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
            return view('admin.users.edit')->with(compact('user'));
        }
        else{
            Session::flash('message', 'User not found!');
            Session::flash('alert-class', 'error');
            return redirect('admin/users');
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
            'email' => 'required|email|unique:users,email,' . $id
        );
        $messages = [            
            'email.required' => 'Please enter email.',
            'email.unique' => 'Provided email is already registered with us.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $adminUser = User::find($id);           
            $adminUser->email = $request['email'];           
            if ($request['password'] != null || !empty($request['password'])) {
                $adminUser->password = bcrypt($request['password']);
            }
            $adminUser->updated_at = date("Y-m-d H:i:s");
            if ($adminUser->save()) {
                Session::flash('message', 'User Updated Succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('admin/users');
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect('admin/users');
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
            if ($id == 1) {
                return "You can't delete Super Admin";
            }

            $user = User::with('roles')->find($id);
            $role = (isset($user->roles) && count($user->roles)) ? $user->roles[0]->id : '';
            if ($user->delete()) {
                if ($role) {
                    $user->removeRole($role);
                }                
                return true;
            } else {
                return 'Something went to wrong';
            }

        }
    }
    public function changeStatus(Request $request)
    {
        return $this->UpdateStatus($request->id, User::class, 'user_status');

    }

    public function emailExsist(Request $request)
    {
        if (isset($request->type) && $request->type == '1') {
            // for update
            $user = User::where('id', '<>', $request->id)->where('email', '=', $request->email)->where('user_status', '!=', '-1')->first();
            if (!empty($user)) {
                echo "false";
            } else {
                echo "true";
            }
        } else {
            $user = User::where('email', '=', $request->email)->where('user_status', '!=', '-1')->first();
            if (!empty($user)) {
                echo "false";
            } else {
                echo "true";
            }
        }
    }
    public function mobilenumberExsist(Request $request)
    {
        if (isset($request->type) && $request->type == '1') {
            // for update
            $user = User::where('id', '<>', $request->id)->where('mobile_number', '=', $request->mobile_number)->where('user_status', '!=', '-1')->first();
            if (!empty($user)) {
                echo "false";
            } else {
                echo "true";
            }
        } else {
            $user = User::where('mobile_number', '=', $request->mobile_number)->where('user_status', '!=', '-1')->first();
            if (!empty($user)) {
                echo "false";
            } else {
                echo "true";
            }
        }

    }
    public function confirmEmail(Request $request)
    {
        $str = $request->get('data');
        $user = User::where('confirmation_code', '=', $str)->first();
        if ($user) {
            $user->user_status = '1';
            $user->confirmation_code = null;
            $user->email_verified_at = date("y-m-d h:i:s");
            $user->email_verified = "1";
            $user->save();
            if (isset($_SERVER['HTTP_USER_AGENT']) and !empty($_SERVER['HTTP_USER_AGENT'])) {
                $user_ag = $_SERVER['HTTP_USER_AGENT'];
                if (preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis', $user_ag)) {
                    header("Status: 301 Moved Permanently");
                    header(env('MOBILE_APP_CALLBACKURL'));
                } else {
                    Session::flash('message', 'Your email has been validated successfully.');
                    Session::flash('alert-class', 'success');
                    return redirect('/login');
                }
            } else {
                Session::flash('message', 'Your email has been validated successfully.');
                Session::flash('alert-class', 'success');
                return redirect('/login');
            }
        } else {
            Session::flash('message', 'Oops !! Link is expired.');
            Session::flash('alert-class', 'danger');
            return redirect('/login');
        }
    }

 

   

   

   

    
}
