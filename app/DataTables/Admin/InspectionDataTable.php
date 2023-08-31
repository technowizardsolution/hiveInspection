<?php

namespace App\DataTables\Admin;

use App\Helper\GlobalHelper;
use App\Inspection;
use Auth;
use Yajra\DataTables\Services\DataTable;

class InspectionDataTable extends DataTable
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
            ->addColumn('action', function ($inspection) {
                $id = $inspection->inspection_id;

                if (auth()->user()->can('inspection-view')) {
                    $view = '<a class="label label-primary badge badge-light-primary" href="' . route('inspection.show', $id) . '"  title="View"><i class="fa fa-eye"></i>&nbsp</a>';
                } else {
                    $view = '';
                }               

                if (auth()->user()->can('inspection-delete')) {
                    $delete = '<a class="label label-danger badge badge-light-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm(' . $id . ')"><i class="fa fa-trash"></i>&nbsp</a>';
                } else {
                    $delete = '';
                }
               

                return $view . ' ' . $delete;
            })   
            ->editColumn('email', function ($inspection) {
                return $inspection->user->email;
            })  
            ->editColumn('hive_date', function ($inspection) {
                return GlobalHelper::getFormattedDate($inspection->hive_date);
            })  
            ->editColumn('created_at', function ($inspection) {
                return GlobalHelper::getFormattedDate($inspection->created_at);
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
        return $model->newQuery()->select('inspection_id', 'hive_date', 'normal_hive_condition', 'created_at', 'updated_at');
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
        return ['inspection_id', 'hive_date', 'normal_hive_condition', 'created_at', 'updated_at'];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Inspection_' . date('YmdHis');
    }
}
