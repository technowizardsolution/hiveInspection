<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\DataTables\Admin\InspectionDataTable;
use App\Device;
use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\User;
use App\Inspection;
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

class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:inspection-list|inspection-delete', ['only' => ['index', 'store']]);        
        $this->middleware('permission:inspection-delete', ['only' => ['destroy']]);

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
    public function index(Builder $builder, InspectionDataTable $dataTable,Request $request)
    {
        $html = $builder->columns([
            ['data' => 'inspection_id', 'name' => 'inspection_id', 'title' => 'ID'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'inspection_date', 'name' => 'inspection_date', 'title' => 'Inspection Date'],            
            ['data' => 'medication_reminder', 'name' => 'medication_reminder', 'title' => 'Medication Reminder'],            
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],            
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'title' => 'Action'],
        ])->parameters([
            'order' => [0, 'desc'],
            'responsive' => true,
            'scrollX' => true,
            'responsive' => true,
        ]);

        if(request()->ajax()) {
            $inspection = Inspection::with('user');
            return $dataTable->dataTable($inspection)->toJson();
        }
        return view('admin.inspection.list', compact('html'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inspection = Inspection::find($id);
        if (!empty($inspection)) {
            return view('admin.inspection.view')->with(compact('inspection'));
        } else {
            Session::flash('message', 'Inspection not found!');
            Session::flash('alert-class', 'error');
            return redirect('admin/inspection');
        }
    }   

    public function create()
    {
        return View('admin.users.create');
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

            $user = Inspection::with('roles')->find($id);
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
   


 

   

   

   

    
}
