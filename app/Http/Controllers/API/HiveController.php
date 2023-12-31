<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Hive;
use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use App\User;
use App\UserToken;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Str;

class HiveController extends Controller
{
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }  

    public function getHiveList()
    {
        try {
            $hive = Hive::where('user_id',Auth()->user()->id)->get();

            if(count($hive)){
				$output = array();
				foreach ($hive as $key => $value) {
					$result['hive_id'] = $value->hive_id;
					$result['hive_name'] = $value->hive_name;					
                    $result['location'] = $value->location;
					$result['build_date'] = $value->build_date;					
                    $result['origin'] = $value->origin;
					$result['deeps'] = $value->deeps;					
                    $result['mediums'] = $value->mediums;
					$result['queen_introduced'] = $value->queen_introduced;					
                    $result['user_id'] = $value->user_id;
					$result['report_file'] = ($value->report_file)? url('/')."/public/report/".$value->report_file:'';				
					$output[] = $result;
				}
                return $this->APIResponse->respondWithMessageAndPayload($output, 'Hive Record');
			}else{
				return $this->APIResponse->respondNotFound('No Practice found.');
			}
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }   

    public function getHiveById($hive_id)
    {
        try {
            $hive = Hive::findorfail($hive_id);
            return $this->APIResponse->respondWithMessageAndPayload($hive, 'Hive Record');
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }    
    
    public function addUpdateHive(Request $request)
    {
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.data_key_notfound')));
            } else {
                $rules = array(
                    'hive_name' => 'required',
                  //  'location' => 'required'
                );
                $messages = [
                    'hive_name.required' => 'Hive name is required',
                   // 'location.required' => 'Location is required'
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    if(isset($data['hive_id'])){
                        $hive = Hive::findorfail($data['hive_id']);
                    }else{
                        $hive = new Hive();
                    }                    
                    $hive->hive_name = $data['hive_name'];
                    $hive->location = $data['location'];
                    $hive->build_date = $data['build_date'];
                    $hive->origin = $data['origin'];
                    $hive->deeps = $data['deeps'];
                    $hive->mediums = $data['mediums'];
                    $hive->queen_introduced = $data['queen_introduced'];
                    $hive->user_id = $request->user()->id;
                    if ($hive->save()) {
                        $hive = GlobalHelper::removeNull($hive);
                        return $this->APIResponse->respondWithMessageAndPayload($hive, 'Hive Filled Successfully');
                    } else {
                        return $this->APIResponse->respondInternalError('Oops ! Something Went Wrong');
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    public function deleteHive(Request $request)
    {
        try {
            $data = $request->json()->get('data');            
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.data_key_notfound')));
            } else {                                
                $hive = Hive::findorfail($data['hive_id']);     
                if ($hive->delete()) {                              
                    return $this->APIResponse->respondWithMessageAndPayload($hive, 'Hive Record Deleted');
                } else {
                    return $this->APIResponse->respondInternalError('Something went wrong.',__('Something went wrong.'));
                }            
            }
            
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }    
    

}
