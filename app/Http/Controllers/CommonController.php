<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\User;

class CommonController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function accountDeactivate()
  {
    return view('deactivate_account');
  }
  public function accountDeactivatePost(Request $request)
  {
      $rules = array(
          'email' => 'required',
          'password' => 'required',
      );
      $messages = [
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
          return redirect()->back()
                          ->withErrors($validator)
                          ->withInput();
      } else {
          $record = User::where('email',$request->email)->first();
          if (!empty($record)) {
            if ($record->user_status == '1') {
              $record->user_status = '0';
              $record->save();
              Session::flash('message', 'Account Deleted Succesfully !');
              Session::flash('alert-class', 'success');
              return redirect()->back()->with('message', 'Account Deleted Succesfully!');
            }elseif ($record->user_status == '0') {
              Session::flash('message', 'Account Already Deleted !');
              Session::flash('alert-class', 'success');
              return redirect()->back()->with('message', 'Account Already Deleted !');
            }

          }else {
            Session::flash('message', 'No user found!');
            Session::flash('alert-class', 'error');
            return redirect()->back()->with('message', 'No user found!');
          }
      }
  }

  public function about()
  {
    return view('about');
  }

  public function termsPrivacy()
  {
    return view('termsPrivacy');
  }
  
}
