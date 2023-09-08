<?php

namespace App\Http\Controllers\Admin;

use Str;
use Session;
use Validator;
use DataTables;
use App\CMSPage;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\CMSPagesDataTable;

class CMSPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:page-list|page-create|page-edit|page-delete|page-status-change|page-view', ['only' => ['index','store']]);
        $this->middleware('permission:page-create', ['only' => ['create','store']]);
        $this->middleware('permission:page-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);
        $this->middleware('permission:page-status-change', ['only' => ['changeStatus']]);
        $this->middleware('permission:page-view', ['only' => ['show']]);
    }

    public function index(Builder $builder, CMSPagesDataTable $dataTable)
    {
        //dd($pages = CMSPage::all());
        $html = $builder->columns([
            ['data' => 'cms_page_id', 'name' => 'cms_page_id','title' => 'ID'],
            ['data' => 'page_title', 'name' => 'page_title','title' => 'Title'],
            //['data' => 'slug', 'name' => 'slug','title' => 'Slug'],
            //['data' => 'status', 'name' => 'status','title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at','title' => 'Scaned At'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false,'title' => 'Action'],
        ])->parameters([
            'order' => [0,'desc'],
            'scrollX' => 'true',
            'stateSave' => true,
            'responsive' => true,
        ]);

        if(request()->ajax()) {
            $pages = CMSPage::select('*');//where('status','1');
            return $dataTable->dataTable($pages)->toJson();
        }

        return view('admin.cmsPages.list', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = ['action'  => 'Create','url'=>'admin/pages/','method'   => 'POST'];
        return View('admin.cmsPages.edit')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'page_title' => 'required',
            // 'content' => 'required',
            // 'metaDescription' => 'sometimes',
            // 'metaKeyword' => 'sometimes',
        ];

        $messages = ['page_title.required'=>'Please enter page title.
'];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $pages = new CMSPage();
            $slug = ($request->slug!=null) ? $request->slug : Str::slug($request->page_title, '-');
            $pages->page_title = $request->page_title;            
            $pages->content = $request->content;
            // $pages->metaDescription = $request->metaDescription;
            // $pages->metaKeyword = $request->metaKeyword;
            $pages->status = '1';
            if($pages->save()) {
                Session::flash('message', 'Page added succesfully!');
                Session::flash('alert-class', 'success');
                return redirect('admin/pages');
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect()->back();
            }
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
        $pages = CMSPage::find($id);
        $data = ['pages'=>$pages, 'action'  => 'Update','url'=>'admin/pages/'.$id,'method'   => 'PUT'];
        return View('admin.cmsPages.edit')->with($data);
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

        $rules = [
            'cms_page_id' => 'required',
            'page_title' => 'required',
            // 'content' => 'required',
            // 'metaDescription' => 'sometimes',
            // 'metaKeyword' => 'sometimes',
        ];
        $messages = [
            'page_title.required' => 'Please enter page title.
'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $slug = ($request->slug!=null) ? $request->slug : Str::slug($request->page_title, '-');
            $pages = CMSPage::find($request->cms_page_id);
            $pages->page_title = $request->page_title;
            //$pages->slug = $slug;
            $pages->content = $request->content;
            // $pages->metaDescription = $request->metaDescription;
            // $pages->metaKeyword = $request->metaKeyword;
            $pages->updated_at = date("Y-m-d H:i:s");

            if ($pages->save()) {

                Session::flash('message', 'Page Updated Succesfully !');
                Session::flash('alert-class', 'success');
                return redirect('admin/pages');
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect('admin/pages');
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
            $page = CMSPage::find($id);
            if($page->delete())
                 return true;
             else
                return 'Something went to wrong';

        }
    }
     public function changeStatus(Request $request)
    {
        return $this->UpdateStatus($request->id,CMSPage::class,'status');
    }
}
