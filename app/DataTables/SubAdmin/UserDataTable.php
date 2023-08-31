<?php

namespace App\DataTables\SubAdmin;

use App\User;
use Yajra\DataTables\Services\DataTable;
use App\Helper\GlobalHelper;
use Auth;

class UserDataTable extends DataTable
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
        ->addColumn('action', function ($user) {
            $id = $user->id;
            $edit = '<a class="label label-success badge badge-light-success" href="' . route('subAdminUserEdit',$id) . '"  title="Update"><i class="fa fa-edit"></i>&nbsp</a>';

            $delete = '<a class="label label-danger badge badge-light-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$id.')"><i class="fa fa-trash"></i>&nbsp</a>';

            $view = '<a class="label label-primary badge badge-light-primary" href="'. route('subAdminUserShow',$id).'"  title="View"><i class="fa fa-eye"></i>&nbsp</a>';
            return $view.' '.$edit.' '.$delete;
        })
        ->addColumn('status',  function($user) {
            $id = $user->id;
            $status = $user->user_status;
            $class='text-danger';
            $label='Deactive';
            if($status==1)
            {
                $class='text-success';
                $label='Active';
            }
            return  '<a class="'.$class.' actStatus" id = "user'.$id.'" data-sid="'.$id.'">'.$label.'</a>';

        })
        ->editColumn('created_at', function($user) {
            return GlobalHelper::getFormattedDate($user->created_at);
        })
        ->editColumn('dob', function($user) {
            return GlobalHelper::getFormattedDate($user->dob);
        })
        ->rawColumns(['status','action','registeredUsing']);//->toJson();
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select('id', 'first_name', 'last_name', 'email','mobile_number','social_provider', 'user_status', 'created_at', 'updated_at');
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
