<?php

namespace App\DataTables\Admin;

use App\Helper\GlobalHelper;
use App\Hive;
use Auth;
use Yajra\DataTables\Services\DataTable;

class HiveDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        //dd($query);
        return datatables($query)
            ->addColumn('action', function ($hive) {
                $id = $hive->hive_id;

                if (auth()->user()->can('hive-view')) {
                    $view = '<a class="label label-primary badge badge-light-primary" href="' . route('hive.show', $id) . '"  title="View"><i class="fa fa-eye"></i>&nbsp</a>';
                } else {
                    $view = '';
                }   
                
                if (auth()->user()->can('hive-edit')) {
                    $edit = '<a class="label label-success badge badge-light-success" href="' . route('hive.edit', $id) . '"  title="Update"><i class="fa fa-edit"></i>&nbsp</a>';

                } else {
                    $edit = '';
                }

                if (auth()->user()->can('hive-delete')) {
                    $delete = '<a class="label label-danger badge badge-light-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm(' . $id . ')"><i class="fa fa-trash"></i>&nbsp</a>';
                } else {
                    $delete = '';
                }
               

                return $view . ' ' .$edit. ' ' .$delete;
            })   
            ->editColumn('email', function ($hive) {
                return $hive->user->email;
            })  
            ->editColumn('build_date', function ($hive) {
                return GlobalHelper::getFormattedDate($hive->build_date);
            })  
            ->editColumn('created_at', function ($hive) {
                return GlobalHelper::getFormattedDate($hive->created_at);
            })            
            ->rawColumns(['action', 'created_at']); //->toJson();
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inspection $model)
    {
        return $model->newQuery()->select('hive_id', 'hive_name', 'location', 'created_at', 'updated_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return ['hive_id', 'hive_name', 'location', 'created_at', 'updated_at'];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Hive_' . date('YmdHis');
    }
}
