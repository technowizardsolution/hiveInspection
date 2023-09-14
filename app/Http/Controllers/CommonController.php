<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Response\APIResponse;
use Validator;
use Session;
use App\User;
use App\CMSPage;

class CommonController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function __construct()
  {
      $this->APIResponse = new APIResponse();
  }  

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
    $about = CMSPage::where('slug','about')->first();
    return view('about')->with(compact('about'));   
  }

  public function termsPrivacy()
  {
    $privacy = CMSPage::where('slug','privacy-policy')->first();
    return view('termsPrivacy')->with(compact('privacy'));       
  }

  public function getCMSPages(Request $request)
    {
        $data = $request->json()->get('data');        
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.data_key_notfound')));
            } else {
                $slug = $data['slug'];
                $cmspage = CMSPage::where('slug',$slug)->first();
                if($cmspage){
                  return $this->APIResponse->respondWithMessageAndPayload($cmspage, 'CMS Record');
                }else{
                  return $this->APIResponse->respondInternalError('Something went wrong.',__('Something went wrong.'));
                }
                
            }
        }  catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }  

    }
  
}
