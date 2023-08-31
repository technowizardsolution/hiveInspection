<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Zxing\QrReader;
use Str;
use Crypt;
use Google2FA;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        return view('admin.profile')->with(compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // Update Password
        if (isset($request['old_password']) && $request['old_password'] != '') {
            $rules = array(
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            );
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $user = User::find($id);
                if (Hash::check($request['old_password'], $user->password)) {
                    $user->password = bcrypt($request['new_password']);
                    $user->save();
                    //Auth::logout();
                    Session::flash('message', 'Password updated successfully!!');
                    Session::flash('alert-class', 'success');
                    return redirect('admin/profile');
                } else {
                    Session::flash('message', 'Oops !! current password is wrong, please try again.');
                    Session::flash('alert-class', 'error');
                    return redirect('admin/profile');
                }
            }
        } elseif (isset($request->password_reset_frequency) && !empty($request->password_reset_frequency)) {
            $rules = array(
                'password_reset_frequency' => 'required',
            );
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $user = User::find(Auth::user()->id);
                if ($user) {
                    $user->password_reset_frequency = $request['password_reset_frequency'];
                    $user->save();
                    //Auth::logout();
                    Session::flash('message', 'Password Reset Frequency updated successfully!!');
                    Session::flash('alert-class', 'success');
                    return redirect('admin/profile');
                } else {
                    Session::flash('message', 'User Not Found.');
                    Session::flash('alert-class', 'error');
                    return redirect('admin/profile');
                }
            }
        } else {
            // update user details
            $rules = array(
                'name' => 'required',
                'profile_picture' => 'nullable',
                'mobile_number' => 'required|numeric|unique:users,mobile_number,' . $id . ',id',
            );
            $messages = [];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $editUser = User::find($id);
                $editUser->first_name = $request['name'];
                $editUser->mobile_number = $request['mobile_number'];
                $editUser->updated_at = date("Y-m-d H:i:s");
                if (!empty($request->main_image) || $request->main_image != '') {
                    $data = explode(';', $request->main_image);
                    $part = explode("/", $data[0]);
                    $image = $request->main_image; // your base64 encoded
                    $image = str_replace('data:image/' . $part[1] . ';base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $fileName = md5(microtime() . Str::random(10)) . '.' . $part[1];
                    $destinationPath = base_path() . '/resources/uploads/profile/';
                    \File::put(base_path() . '/resources/uploads/profile/' . $fileName, base64_decode($image));
                    chmod($destinationPath . $fileName, 0777);
                    $editUser->profile_picture = $fileName;
                    $image = url('/') . '/resources/uploads/profile/' . $fileName;
                } else {
                    $image = '';
                }
                if (!empty($request['profile_picture_snapshot']) || $request['profile_picture_snapshot'] != null) {
                    $destinationPath = base_path() . '/resources/uploads/profile/';
                    $img = $request['profile_picture_snapshot'];
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = md5(microtime()) . ".png";
                    $file = $destinationPath . $fileName;
                    file_put_contents($file, $image_base64);
                    $editUser->profile_picture = $fileName;
                }

                if ($editUser->save()) {
                    Session::flash('message', 'Profile information updated !!');
                    Session::flash('alert-class', 'success');
                    return redirect('admin/profile');
                } else {
                    Session::flash('message', 'Oops !! Something went wrong please try again after some times');
                    Session::flash('alert-class', 'error');
                    return redirect('admin/profile');
                }
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
        //
    }
}
