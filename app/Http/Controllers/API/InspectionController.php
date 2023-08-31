<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Hive;
use App\Inspection;
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

class InspectionController extends Controller
{
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }  

    public function getInspectionById($inspection_id)
    {
        try {
            $inspection = Inspection::findorfail($inspection_id);
            return $this->APIResponse->respondWithMessageAndPayload($inspection, 'Inspection Record');
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }    
    
    public function addInspection(Request $request)
    {
        $data = $request->json()->get('data');
        try {
            if (empty($data)) {
                return $this->APIResponse->respondNotFound(__(Lang::get('messages.data_key_notfound')));
            } else {
                $rules = array(
                    'hive_date' => 'required',
                    'normal_hive_condition' => 'required'
                );
                $messages = [
                    'hive_date.required' => 'Hive date is required',
                    'normal_hive_condition.required' => 'Normal hive condition is required'
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return $this->APIResponse->respondValidationError(__($validator->errors()->first()));
                } else {
                    if(isset($data['inspection_id'])){
                        $inspection = Inspection::findorfail($data['inspection_id']);
                    }else{
                        $inspection = new Inspection();
                    }   
                    $inspection->user_id = $request->user()->id;
                    $inspection->inspection_date = $data['inspection_date'];
                    $inspection->normal_hive_condition = $data['normal_hive_condition'];
                    $inspection->saw_queen = $data['saw_queen'];
                    $inspection->queen_marked = $data['queen_marked'];
                    $inspection->eggs_seen = $data['eggs_seen'];
                    $inspection->larva_seen = $data['larva_seen'];
                    $inspection->pupa_seen = $data['pupa_seen'];
                    $inspection->drone_cells = $data['drone_cells'];
                    $inspection->queen_cells = $data['queen_cells'];
                    $inspection->hive_beetles = $data['hive_beetles'];
                    $inspection->wax_moth = $data['wax_moth'];
                    $inspection->noseema = $data['noseema'];
                    $inspection->mite_wash = $data['mite_wash'];
                    $inspection->mite_count = $data['mite_count'];
                    $inspection->temperment = $data['temperment'];
                    $inspection->population = $data['population'];
                    $inspection->solid_uniform_frames = $data['solid_uniform_frames'];
                    $inspection->slightly_spotty_frames = $data['slightly_spotty_frames'];
                    $inspection->spotty_frames = $data['spotty_frames'];
                    $inspection->normal_odor = $data['normal_odor'];
                    $inspection->brood = $data['brood']; 
                    $inspection->honey = $data['honey'];
                    $inspection->pollen = $data['pollen'];
                    $inspection->frames_of_bees = $data['frames_of_bees'];
                    $inspection->frames_of_brood = $data['frames_of_brood']; 
                    $inspection->frames_of_honey = $data['frames_of_honey'];
                    $inspection->frames_of_pollen = $data['frames_of_pollen']; 
                    $inspection->honey_supers = $data['honey_supers'];
                    $inspection->add_supers = $data['add_supers']; 
                    $inspection->weigh_super_3 = $data['weigh_super_3'];
                    $inspection->weigh_super_2 = $data['weigh_super_2']; 
                    $inspection->weigh_super_1 = $data['weigh_super_1'];
                    $inspection->weigh_brood_3 = $data['weigh_brood_3'];
                    $inspection->weigh_brood_2 = $data['weigh_brood_2'];
                    $inspection->weigh_brood_1 = $data['weigh_brood_1']; 
                    $inspection->prep_for_extraction = $data['prep_for_extraction'];
                    $inspection->feed_hive_what = $data['feed_hive_what'];
                    $inspection->install_medication_what = $data['install_medication_what']; 
                    $inspection->remove_medication = $data['remove_medication'];
                    $inspection->split_hive = $data['split_hive'];
                    $inspection->re_queen = $data['re_queen']; 
                    $inspection->swap_brood_boxes = $data['swap_brood_boxes'];
                    $inspection->insulate_winterize = $data['insulate_winterize']; 
                    $inspection->additional_notes = $data['additional_notes'];
                    if ($inspection->save()) {
                        //$hive = GlobalHelper::removeNull($hive);
                        return $this->APIResponse->respondWithMessageAndPayload($inspection, 'Inspection Filled Successfully');
                    } else {
                        return $this->APIResponse->respondInternalError('Oops ! Something Went Wrong');
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    public function getInspectionHistory(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $inspection = Inspection::where('user_id',$user_id)->get();
            return $this->APIResponse->respondWithMessageAndPayload($inspection, 'Inspection Record');
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }  
    

}
