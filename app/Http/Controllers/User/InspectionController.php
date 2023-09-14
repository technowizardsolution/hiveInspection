<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Inspection;
use App\Hive;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InspectionExport;
use Response;


class InspectionController extends Controller
{
    public function index($hive_id)
    {
        $user = Auth::user();        
        return view('user.inspection.add',compact('user','hive_id'));
    }

    public function inspectionExport($hive_id)
    {
        $inspection = Inspection::where('hive_id',$hive_id)->get();
        if(count($inspection) > 0){
            $export = new InspectionExport($hive_id);
            $hivedata = Hive::find($hive_id);
            $name = str_replace(' ', '', $hivedata->hive_name);
            $fileName = $name.'_inspection.xlsx';
            Excel::store($export, $fileName);
            $hivedata->report_file = $fileName;
            $hivedata->save(); 
            $file= public_path()."/report/".$fileName;
            $headers = array('Content-Type: application/excel');
            return Response::download($file, $fileName, $headers);  
            
        }else{
            Session::flash('message', 'Inspection data is not available.');
            Session::flash('alert-class', 'error');
            return redirect('user/hive'); 
        }
             

        //return Excel::download($export, $fileName);
    }

    public function getDownload()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/download/info.pdf";

        $headers = array(
                'Content-Type: application/pdf',
                );

        return Response::download($file, 'filename.pdf', $headers);
    }


    public function store(Request $request)
    {
        
        $rules = array(            
            'hive_id' => 'required'
        );
        $messages = [            
            'hive_id.required' => 'Please enter hive.',            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }           

        $inspection = new Inspection();        
        $inspection->hive_id = $request['hive_id'];
        $inspection->user_id = Auth::user()->id;
        $inspection->inspection_date = $request['inspection_date'];
        if($request['normal_hive_condition']){
            $inspection->normal_hive_condition = $request['normal_hive_condition'];
        }        
        if($request['saw_queen']){
            $inspection->saw_queen = $request['saw_queen'];
        }
        if($request['queen_marked']){
            $inspection->queen_marked = $request['queen_marked'];
        }
        if($request['eggs_seen']){
            $inspection->eggs_seen = $request['eggs_seen'];
        }
        if($request['larva_seen']){
            $inspection->larva_seen = $request['larva_seen'];
        }
        if($request['pupa_seen']){
            $inspection->pupa_seen = $request['pupa_seen'];
        }
        if($request['drone_cells']){
            $inspection->drone_cells = $request['drone_cells'];
        }
        if($request['queen_cells']){
            $inspection->queen_cells = $request['queen_cells'];
        }
        if($request['hive_beetles']){
            $inspection->hive_beetles = $request['hive_beetles'];
        }
        if($request['wax_moth']){
            $inspection->wax_moth = $request['wax_moth'];
        }
        if($request['noseema']){
            $inspection->noseema = $request['noseema'];
        }
        if($request['mite_wash']){
            $inspection->mite_wash = $request['mite_wash'];
        }        
        $inspection->mite_count = $request['mite_count'];
        $inspection->temperment = $request['temperment'];
        $inspection->population = $request['population'];
        if($request['solid_uniform_frames']){
            $inspection->solid_uniform_frames = $request['solid_uniform_frames_input'];
        }        
        if($request['slightly_spotty_frames']){
            $inspection->slightly_spotty_frames = $request['slightly_spotty_frames_input'];
        }        
        $inspection->spotty_frames = $request['spotty_frames'];
        $inspection->normal_odor = $request['normal_odor'];
        $inspection->brood = $request['brood']; 
        $inspection->honey = $request['honey'];
        $inspection->pollen = $request['pollen'];
        $inspection->frames_of_bees = $request['frames_of_bees'];
        $inspection->frames_of_brood = $request['frames_of_brood']; 
        $inspection->frames_of_honey = $request['frames_of_honey'];
        $inspection->frames_of_pollen = $request['frames_of_pollen']; 
        if($request['honey_supers']){
            $inspection->honey_supers = $request['honey_supers_input'];
        }
        
        if($request['add_supers']){
            $inspection->add_supers = $request['add_supers_input']; 
        }        
        if($request['weigh_super_3']){
            $inspection->weigh_super_3 = $request['weigh_super_3_input'];
        }        
        if($request['weigh_super_2']){
            $inspection->weigh_super_2 = $request['weigh_super_2_input']; 
        }
        if($request['weigh_super_1']){
            $inspection->weigh_super_1 = $request['weigh_super_1_input'];
        }        
        if($request['weigh_super_1']){
            $inspection->weigh_brood_3 = $request['weigh_brood_3_input'];
        }
        if($request['weigh_brood_2']){
            $inspection->weigh_brood_2 = $request['weigh_brood_2_input'];
        }
        if($request['weigh_brood_1']){
            $inspection->weigh_brood_1 = $request['weigh_brood_1_input']; 
        }        
        if($request['prep_for_extraction']){
            $inspection->prep_for_extraction = $request['prep_for_extraction'];
        }        
        if($request['feed_hive_what']){
            $inspection->feed_hive_what = $request['feed_hive_what_input'];
        }
        if($request['install_medication_what']){
            $inspection->install_medication_what = $request['install_medication_what_input']; 
        }        
        if($request['remove_medication']){
            $inspection->remove_medication = $request['remove_medication'];
        }        
        if($request['split_hive']){
            $inspection->split_hive = $request['split_hive'];
        }        
        if($request['re_queen']){
            $inspection->re_queen = $request['re_queen']; 
        }        
        if($request['swap_brood_boxes']){
            $inspection->swap_brood_boxes = $request['swap_brood_boxes'];
        }
        if($request['insulate_winterize']){
            $inspection->insulate_winterize = $request['insulate_winterize']; 
        }   
        if($request['medication_reminder']){
            $inspection->medication_reminder = $request['medication_reminder']; 
        }   
        $inspection->additional_notes = $request['additional_notes'];             
        if ($inspection->save()) {
            Session::flash('message', 'Inspection added succesfully !');
            Session::flash('alert-class', 'success');
            return redirect('user/hive');

        } else {
            Session::flash('message', 'Oops !! Something went wrong!');
            Session::flash('alert-class', 'error');
            return redirect('user/hive');
        }
    }
}
