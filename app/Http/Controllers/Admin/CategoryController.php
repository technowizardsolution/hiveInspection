<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Validator;
use DataTables;
use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\CategoryDataTable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:categories-list|categories-create|categories-edit|categories-delete|categories-status-change|categories-view', ['only' => ['index','store']]);
        $this->middleware('permission:categories-create', ['only' => ['create','store']]);
        $this->middleware('permission:categories-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:categories-delete', ['only' => ['destroy']]);
        $this->middleware('permission:categories-status-change', ['only' => ['changeStatus']]);
        $this->middleware('permission:categories-view', ['only' => ['show']]);
    }
    public function index(Builder $builder, CategoryDataTable $dataTable)
    {
       $html = $builder->columns([
            ['data' => 'category_id', 'name' => 'category_id','title' => 'ID'],
            ['data' => 'name', 'name' => 'name','title' => 'Name'],
            ['data' => 'status', 'name' => 'status','title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at','title' => 'Scaned At'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false,'title' => 'Action'],
        ])->parameters([
            'order' => [0,'desc'],
            'responsive' => true
        ]);

        if(request()->ajax()) {
            $users = Category::select('*');//where('status','1');
            return $dataTable->dataTable($users)->toJson();
        }

        return view('admin.categories.list', compact('html'));
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
        $rules = [
            'name' => 'required|min:2|max:40'
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $category = new Category();
            $category->name = $request->name;
            if($category->save()) {
                Session::flash('message', 'Category added succesfully!');
                Session::flash('alert-class', 'success');
                return redirect()->back();
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
        $category = Category::findOrfail($id);
        return view('admin.categories.edit', compact('category'));
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
            'name' => 'required|min:2|max:40'
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $category = Category::find($id);
            $category->name = $request->name;
            if($category->save()) {
                Session::flash('message', 'Category updated succesfully!');
                Session::flash('alert-class', 'success');
                return redirect('admin/categories');
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoty_id)
    {
        $category = Category::destroy($categoty_id);
        if($category)
            return true;
        else
            return 'Something went to wrong!';
    }
    public function changeStatus(Request $request)
    {
        return $this->UpdateStatus($request->id,Category::class,'status');
    }
}
