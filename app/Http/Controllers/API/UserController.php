<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\ContactUs;
use App\FAQ;
use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use App\Notifications\APIForgotPassword;
use App\Notifications\ForgotPassword;
use App\Notifications\UserRegistration;
use App\SubCategory;
use App\User;
use App\UserToken;
use App\Inspection;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Str;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }
    public function form_data()
    {
        $form_data = ['gender' => ['Male', 'Female'],
            'martial_status' => ['Single', 'Married', 'Living Together', 'Divorced', 'Common Law', 'Widowed'],
            'no_of_dependents' => ['0', '1', '2', '3', '4+'],
            'eduction' => ['Did Not Finish High School', 'High School', 'College', "Bachelor's Degree", "Master's Degree", 'Phd'],
            'residence_type' => ['Apartment Building (less than 10 units)', 'Apartment Building (10 units or more)', 'Codominium', 'Single Detached House', 'Semi Detached House', 'Townhouse', 'Other'],
            'address_lived_time' => ['6 Months or Less', '7 to 12 Months', '1 to 2 Years', '3 to 6 Years', '7+ Years'],
            'home_status' => ['Rent', 'Own (With Mortgage)', 'Own (Without Mortgage)', 'Living with Family', 'Living with Roomates', 'Social Housing'],
            'income_source' => ['Canada Pension', 'Child Tax Benefit', 'Employment Insurance', 'Old Age Pension', 'Ontario Disability Support Program', 'Veterans Disability'],
            'time_revenue' => ['3 Months or Less', '4 to 6 Months', '7 to 12 Months', '1 to 2 Years', '3 to 6 Years', '7+'],
            'form_of_payment' => ['Direct Deposit', 'Cheque', 'Cash', 'E-Transfer'],
            'frequency_pay' => ['Weekly', 'Bi-Weekly', 'Monthly', 'Bi-Monthly'],
            'account_creation_date' => ['3 Months', '4 to 6 Months', '7 to 12 Months', '1 to 2 Years', "3' to 6 Years", '7+'],
            'e_transfers' => ['Yes I can receive e-transfers', 'No my bank prohibits e-transfers', 'No my email is blacklisted from the bank', 'No I prefer cash in store'],
            'is_bankruptcy' => ['Yes', 'No'],
            'number_of_bankruptcy' => ['0', '1', '2', '3', '4+'],
            'number_of_active_loan' => ['0', '1', '2', '3', '4+'],
            'loan_type' => ['Payday Loans', 'Personal Loans', 'Both', 'Other'],
            'overdue_loan' => ['Yes', 'No'],
        ];
    }

    /**
     * Developed By :
     * Description  : Registration
     * Date         :
     */
    public function register(Request $request)
    {
        $data = $request->json()->get('data');        
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__('Data key not found or Empty'));
            } else {
                $rules = array(                    
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,16}$/',
                );
                $messages = [                    
                    'password.regex' => 'Password must be minimum 6 and maximum 16 characters and alphanumeric with atleast one uppercase, one lowercase, one special character and one digit.',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    $confirmation_code = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 20);
                    $newuser = new User();                    
                    $newuser->email = $data['email'];
                    $newuser->password = bcrypt($data['password']);
                    $newuser->social_provider = 'normal';
                    $newuser->confirmation_code = $confirmation_code;
                    if ($newuser->save()) {
                        //dispatch(new UserRegistrationEmailJob($newuser));
                        //$newuser->notify(new UserRegistration($newuser));
                        $newuser->assignRole(2);
                        return $this->APIResponse->respondWithMessageAndPayload($newuser, 'Successfully registered!');
                    } else {
                        return $this->APIResponse->respondInternalError(__(Lang::get('messages.registrationfailed')));
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Login
     * Date         :
     */
    public function login(Request $request)
    {
        $data = $request->json()->get('data');
       // $browser = get_browser(null, true);
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound("Data Key Not Found Or Empty");
            } else {
                $rules = array(
                    'email' => ' required|email|max:255',
                    'password' => 'required',
                );
                $messages = [
                    'email.required' => Lang::get('messages.please_enter_email_id'),
                    'password.required' => Lang::get('messages.please_enter_password'),
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    $checkUserExists = User::where('email', $data['email'])->first();
                    if (empty($checkUserExists)) {
                        return $this->APIResponse->respondNotFound(Lang::get('messages.emailnotregistered'));
                    } else {
                        if ($checkUserExists->email_verified == '0' || $checkUserExists->email_verified == null) {
                            return $this->APIResponse->respondUnauthorized('Your email is not verified. Please verify first via received Mail and then try to login.');
                        } else {
                            if ($checkUserExists->user_status == '0' || $checkUserExists->user_status == null) {
                                return $this->APIResponse->respondUnauthorized(__(Lang::get('messages.accountblockbyadmin')));
                            } else {
                                if (Hash::check($data['password'], $checkUserExists->password)) {
                                    $token = null;
                                    try {
                                        if (!$token = $checkUserExists->createToken('Laravel')->accessToken) {
                                            return $this->APIResponse->respondUnauthorized(__('Invalid_email_or_password'));
                                        }
                                    } catch (Exception $e) {
                                        return $this->APIResponse->respondInternalError(__('failed_to_create_token'));
                                    }
                                    $checkUserExists['token'] = $token;
                                    $checkUserExists['last_login_at'] = Date('Y-m-d H:i:s');
                                    // $checkUserExists['browser_name'] = $browser['browser'];
                                    // $checkUserExists['ip_address'] = $request->ip();
                                    $checkUserExists['device_type'] = $data['device_type'];
                                    $checkUserExists['device_token'] = $data['device_token'];
                                    $checkUserExists->save();
                                    $checkUserExists = GlobalHelper::removeNull($checkUserExists->toArray());
                                    return $this->APIResponse->respondWithMessageAndPayload($checkUserExists, Lang::get('Login Successfully !'));
                                } else {
                                    return $this->APIResponse->respondUnauthorized('Credential do not match our records !');
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Logout
     * Date         :
     */
    public function logout(Request $request)
    {
        $value = $request->bearerToken();
        $data = $request->json()->get('data');
        // $id = (new Parser())->parse($value)->getHeader('jti');
        // DB::table('oauth_access_tokens')
        //     ->where('id', $id)
        //     ->update([
        //         'revoked' => true
        //     ]);
        //User::where('id',Auth()->user()->id)->update(['device_token' => NULL]);
        UserToken::where('device_token', $data['device_token'])->delete();
        // $user = DB::table('oauth_access_tokens')->where('id', $id)->first();
        // $update = User::where('id', $user->user_id)->update(['last_active'=>date('Y-m-d H:i:s'),'is_active' => '0']);
        return $this->APIResponse->respondWithMessage('You are logged out successfully!');
    }

    /**
     * Developed By :
     * Description  : social registration
     * Date         :
     */

    public function socialRegister(Request $request)
    {
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(trans('messages.data.dataKey_notFound')));
            } else {
                $rules = array(
                    "social_provider" => 'required|in:google,facebook,apple',
                    'social_provider_id' => 'required',
                    // 'email' => 'email|required',
                );
                $messages = [

                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    //check email
                    if (isset($data['email']) && $data['email'] != '') {
                        $emailExsist = User::where('email', $data['email'])->where('social_provider_id', $data['social_provider_id'])->first();
                        if ($emailExsist) {
                            try {
                                if (!$token = $emailExsist->createToken('Laravel')->accessToken) {
                                    return $this->APIResponse->respondUnauthorized(__(trans('messages.invalidEmailOrPassword')));
                                }
                            } catch (Exception $e) {
                                return $this->APIResponse->respondInternalError(__(trans('messages.failed_to_create_token')));
                            }
                            $emailExsist['token'] = $token;
                            return $this->APIResponse->respondWithMessageAndPayload($emailExsist, trans('messages.loginsuccessfully'));
                        }
                    }

                    $checkSocialExists = User::where('social_provider_id', $data['social_provider_id'])->Where('social_provider', $data['social_provider'])->first();
                    if ($checkSocialExists) {
                        $token = null;
                        try {
                            if (!$token = $checkSocialExists->createToken('Laravel')->accessToken) {
                                return $this->APIResponse->respondUnauthorized(__(trans('messages.invalidEmailOrPassword')));
                            }
                        } catch (Exception $e) {
                            return $this->APIResponse->respondInternalError(__(trans('messages.failed_to_create_token')));
                        }
                        $checkSocialExists['token'] = $token;
                        return $this->APIResponse->respondWithMessageAndPayload($checkSocialExists, trans('messages.loginsuccessfully'));
                    } else {
                        $socialnew = new User();
                        $socialnew->first_name = $data['first_name'];
                        $socialnew->social_provider_id = $data['social_provider_id'];
                        $socialnew->social_provider = $data['social_provider'];
                        if (isset($data['email']) && $data['email'] != '') {
                            $socialnew->email = $data['email'];
                        }
                        $socialnew->password = bcrypt('Qwerty@123');
                        $socialnew->user_status = '1';
                        if ($socialnew->save()) {
                            $socialnew->assignRole(2);
                            $token = null;
                            try {
                                if (!$token = $socialnew->createToken('Laravel')->accessToken) {
                                    return $this->APIResponse->respondUnauthorized(__(trans('messages.invalidEmailOrPassword')));
                                }
                            } catch (Exception $e) {
                                return $this->APIResponse->respondInternalError(__(trans('messages.failed_to_create_token')));
                            }
                            $userdata = User::where('social_provider_id', $data['social_provider_id'])->first();
                            $userdata = GlobalHelper::removeNull($userdata->toArray());
                            $userdata['token'] = $token;
                            return $this->APIResponse->respondWithMessageAndPayload($userdata, trans('messages.loginsuccessfully'));

                        } else {
                            return $this->APIResponse->respondUnauthorized(__(trans('messages.registerFail')));
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    public function forgotPassword(Request $request)
    {
       
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.datakey_notfound')));
            } else {
                $rules = array(
                    'email' => 'required|email|max:255',
                );
                $messages = [
                    'email.required' => 'Please enter Email',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    $checkUserExits = User::where('email', $data['email'])->first();
                    if (empty($checkUserExits)) {
                        return $this->APIResponse->respondNotFound(__(Lang::get('messages.emailnotregistered')));
                    } else {
                        if ($checkUserExits->email_verified == '0' || $checkUserExits->email_verified == null) {
                            return $this->APIResponse->respondUnauthorized(__(Lang::get('messages.verifyemailfirst')));
                        } else {
                            $checkUserExits->password_reset_token = Str::random(30);                         
                            if ($checkUserExits->save()) {
                                $checkUserExits->notify(new APIForgotPassword($checkUserExits));

                                return $this->APIResponse->respondWithMessage(Lang::get('messages.passwordrecoverylinksent'));
                            } else {
                                return $this->APIResponse->respondWithMessage(Lang::get('messages.pleasetryagin'));
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Change Password
     * Date         :
     */
    public function changePassword(Request $request)
    {
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__('Data key not found or Empty'));
            } else {
                $rules = array(
                    'old_password' => 'required',
                    'new_password' => 'required|string|min:6|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,16}$/',
                    // regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[@!\]\[\' #$%&\(\)\"<=>?\{\}_~\^\`+-\/\*])/',
                );
                $messages = [
                    'old_password.required' => 'Please enter old password',
                    'new_password.required' => 'Please enter new password',
                    //  // 'password.regex' => "Password must be 5-15 characters with minimum 1 Uppercase, 1 Lowercase, 1 Numeric and 1 Special character.",
                    //   'new_password.min' => "Password cannot have less than 5 characters.",
                    //   'new_password.max' => "Password cannot have more than 15 characters.",
                    'new_password.regex' => 'Password must be minimum 6 and maximum 16 characters and alphanumeric with atleast one uppercase, one lowercase, one special character and one digit.',

                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    $checkUserExits = User::where('id', $request->user()->id)->first();
                    if (empty($checkUserExits)) {
                        return $this->APIResponse->respondNotFound(__(Lang::get('messages.emailnotregistered')));
                    } else {
                        if (Hash::check($data['old_password'], $checkUserExits->password)) {
                            $checkUserExits->password = bcrypt($data['new_password']);
                            if (Hash::check($data['old_password'], $checkUserExits->password)) {
                                return $this->APIResponse->respondNotFound(__("New password must not be the same as old password"));
                            } else {
                                if ($checkUserExits->save()) {
                                    return $this->APIResponse->respondWithMessageAndPayload($checkUserExits, Lang::get('messages.passwordchangesuccessfully'));
                                } else {
                                    return $this->APIResponse->respondInternalError(__(Lang::get('messages.pleasetryagin')));
                                }
                            }
                        } else {
                            return $this->APIResponse->respondNotFound(__("Old password doesnot match"));
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Update device type and device token
     * Date         :
     */
    public function updateDeviceToken(Request $request)
    {
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(trans('messages.dataKey_notFound')));
            } else {
                $rules = array(
                    'device_type' => 'required|in:1,2',
                    'device_token' => 'required',
                    'app_type' => '',
                );
                $messages = [
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    $userDetail = User::where('id', Auth()->user()->id)->first();
                    if (empty($userDetail)) {
                        return $this->APIResponse->respondNotFound(__(trans('messages.user_not_found')));
                    }
                    $userToken = UserToken::where('user_id', Auth()->user()->id)->where('device_token', $data['device_token'])->first();
                    if (!empty($userToken)) {
                        return $this->APIResponse->respondNotFound(trans('messages.device_token_updated'));
                    } else {
                        $userToken = new UserToken();
                        $userToken->user_id = Auth()->user()->id; //device_type 1)Android 2) ios
                        $userToken->device_type = $data['device_type']; //device_type 1)Android 2) ios
                        $userToken->device_token = $data['device_token'];
                        $userToken->app_type = isset($data['app_type']) ? $data['app_type'] : env('APP_TYPE');
                        if ($userToken->save()) {
                            return $this->APIResponse->respondWithMessage(trans('messages.device_token_updated'));
                        } else {
                            return $this->APIResponse->respondInternalError(__(trans('messages.failed_to_update')));
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Update Profile
     * Date         :
     */
    public function updateProfile(Request $request)
    {
        // $data = $request->json()->get('data');
        $data = json_decode(preg_replace('/\s+/', ' ', trim($request->data)), true)['data'];
        try {
            $rules = array(
                "gender" => "sometimes|nullable|in:m,f,o'",
            );
            $messages = [
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
            } else {
                // get id from passport token
                $user_id = $request->user()->id;
                $user = User::find($user_id);
                if (empty($user)) {
                    return $this->APIResponse->respondNotFound(__(trans('messages.record_notFound_givenId')));
                } else {
                    if (isset($data['first_name']) && $data['first_name'] != '') {
                        $user->first_name = $data['first_name'];
                    }
                    if (isset($data['dob']) && $data['dob'] != '') {
                        $user->dob = date('Y-m-d', strtotime($data['dob']));
                    }
                    if (isset($data['mobile_number']) && $data['mobile_number'] != '') {
                        // $mobileNo = explode('-',$data['mobile_number']);
                        // $user->country_code = $data['mobile_number']?$mobileNo[0]?'+'.str_replace('+','',$mobileNo[0]):NULL:NULL;
                        // $user->mobile_number = $data['mobile_number']?$mobileNo[1]?str_replace(' ','',$mobileNo[1]):NULL:NULL;
                        $user->mobile_number = $data['mobile_number'];
                    }
                    if (isset($data['gender']) && $data['gender'] != '') {
                        $user->gender = $data['gender'];
                    }
                    if ($request->hasFile('profile_picture')) {
                        if ($user->getOriginal('profile_picture') && file_exists((base_path() . '/resources/uploads/profile/' . $user->getOriginal('profile_picture')))) {
                            unlink(base_path() . '/resources/uploads/profile/' . $user->getOriginal('profile_picture'));
                        }
                        $file = $request->file('profile_picture');
                        $file->getClientOriginalName();
                        $fileExtension = $file->getClientOriginalExtension();
                        $file->getRealPath();
                        $file->getSize();
                        $file->getMimeType();
                        $fileName = md5(microtime() . $file->getClientOriginalName()) . '.' . $fileExtension;
                        $path = base_path() . '/resources/uploads/profile/';
                        if (!file_exists($path)) {
                            File::makeDirectory($path, 0777, true);
                            chmod($path, 0777);
                        }
                        $upload = $request->file('profile_picture')->move(
                            $path, $fileName
                        );
                        chmod($path . $fileName, 0777);
                        $user->profile_picture = $fileName;
                    }

                    if ($user->save()) {
                        return $this->APIResponse->respondWithMessageAndPayload($user, trans('messages.update_successfully'));
                    } else {
                        return $this->APIResponse->respondInternalError(__(trans('messages.failed_update_profile')));
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Get Profile
     * Date         :
     */
    public function getProfile(Request $request)
    {
        try {
            $userDetail = User::where('id', Auth()->user()->id)->where('user_status', '1')->first();
            if (empty($userDetail)) {
                return $this->APIResponse->respondNotFound('No record Found');
            } else {
                $userDetail['role_id'] = $userDetail->roles->first()->id;
                $userDetail = GlobalHelper::removeNull($userDetail);
                return $this->APIResponse->respondWithMessageAndPayload($userDetail, 'Profile Detail');
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Category
     * Date         :
     */
    public function getCategory(Request $request)
    {
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound('data key not found!');
            } else {
                $rules = array(
                );
                $messages = [
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    if (isset($data['category']) && $data['category'] != "") {
                        $userCategory = Category::where('status', '1')->where('name', 'LIKE', "%{$data['category']}%")->get()->toArray();
                    } else {
                        $userCategory = Category::where('status', '1')->get()->toArray();
                    }
                    if (empty($userCategory)) {
                        return $this->APIResponse->respondNotFound('No Category Found');
                    } else {
                        return $this->APIResponse->respondWithMessageAndPayload($userCategory, 'Category List');
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Developed By :
     * Description  : Sub Category
     * Date         :
     */
    public function getSubcategory(Request $request)
    {

        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.data_key_notfound')));
            } else {
                $rules = array(
                    'category_id' => 'required',
                );
                $messages = [
                    'category_id.required' => 'category_id field is required',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    $category_id = $data['category_id'];
                    if (isset($data['subcategory']) && $data['subcategory'] != "") {
                        $subcategory = SubCategory::where('category_id', $category_id)->with('category')->where('name', 'LIKE', "%{$data['subcategory']}%")->get()->toArray();
                    } else {
                        $subcategory = SubCategory::where('category_id', $category_id)->with('category')->get()->toArray();
                    }
                    if ($subcategory) {
                        return $this->APIResponse->respondWithMessageAndPayload($subcategory, 'Sub Category List');
                    } else {
                        return $this->APIResponse->respondNotFound('Category List');
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }



 
   

    public function testnotification(Request $request)
    {
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.data_key_notfound')));
            } else {
                if (isset($data['token'])) {
                    // GlobalHelper::sendFCMIOS("Test Notification", "Test" , $data['token'] ,'');
                    GlobalHelper::sendFCM("Test Notification", "Test", $data['token'], 'thgvg');
                    return $this->APIResponse->respondWithMessage('Notification Sent Successfully');
                } else {
                    return $this->APIResponse->respondWithMessage('Token Invalid');
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    public function updateNotification(Request $request)
    {
        $data = $request->json()->get('data');        
        try {

            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.data_key_notfound')));
            } else {
                $rules = array(
                    'notification_status' => 'required',
                );
                $messages = [
                    'notification_status.required' => 'notification_status field is required',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    $notification_status = $data['notification_status'];
                    $user_id = $request->user()->id;
                    $user = User::find($user_id);
                    $user->notification_status = $notification_status;
                    if ($user->save()) {
                        return $this->APIResponse->respondWithMessageAndPayload($user, trans('messages.update_successfully'));
                    } else {
                        return $this->APIResponse->respondInternalError(__(trans('messages.failed_update_profile')));
                    }
                }
            }

            

        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }    
     
    }    

    public function sendReminder(Request $request)
    {
        $inspections = Inspection::whereNotNull('medication_reminder')->whereDate('medication_reminder', Carbon::today())->with('user')->get();
        foreach($inspections as $inspection) {
            GlobalHelper::sendFCM("Medication Reminder", "Hello, this is a medication reminder for your hive inspection", $inspection['user']['device_token']);
        }
        return true;
    }   





}
