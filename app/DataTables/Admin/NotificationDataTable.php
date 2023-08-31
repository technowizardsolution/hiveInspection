<?php

namespace App\DataTables\Admin;

use App\User;
use Yajra\DataTables\Services\DataTable;
use App\Helper\GlobalHelper;

class NotificationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->editColumn('created_at', function($data) {
            return GlobalHelper::getFormattedDate($data->created_at);
        })
        ->editColumn('notification_from_user_id', function($data) {
            if($data['userDetailFrom']){
                return $data['userDetailFrom']->first_name .' '.$data['userDetailFrom']->last_name;
            }else{
                return '-';
            }
        })
         ->editColumn('notification_to_user_id', function($data) {
            if($data['userDetailTo']){
                return $data['userDetailTo']->first_name .' '.$data['userDetailTo']->last_name;
            }else{
                return '-';
            }
        })
        ->filterColumn('notification_from_user_id', function($query, $keyword) {
              $id = User::where('first_name', 'LIKE', '%' . $keyword . '%')->orwhere('last_name', 'LIKE', '%' . $keyword . '%')->pluck('id');
              $query->wherein('notification_from_user_id',$id);
        })
        ->filterColumn('notification_to_user_id', function($query, $keyword) {
              $id = User::where('first_name', 'LIKE', '%' . $keyword . '%')->orwhere('last_name', 'LIKE', '%' . $keyword . '%')->pluck('id');
              $query->wherein('notification_to_user_id',$id);
        })
        ->filterColumn('created_at', function($query, $keyword) {
            $sql = 'DATE_FORMAT(created_at,"%d-%M-%Y") like ?';
            $query->whereRaw($sql, ["%{$keyword}%"]);
        })
        ->rawColumns(['created_at','full_name']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select();
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
        return ['id', 'first_name', 'last_name', 'email','mobile_number','social_provider', 'user_status', 'created_at', 'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
