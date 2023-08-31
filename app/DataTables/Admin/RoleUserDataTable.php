<?php

namespace App\DataTables\Admin;

use App\Role;
use Yajra\DataTables\Services\DataTable;

class RoleUserDataTable extends DataTable
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
        ->addColumn('email', function ($roleuser) {
           return $roleuser->email;
        })
        ->addColumn('user_id',  function($roleuser) {
          return $roleuser->id ;
        })
        ->editColumn('role_id',function($roleuser){
            $role = $roleuser->getRoleNames()->toArray();
            return $role[0];
        })
        ->addColumn('status',  function($roleuser) {
            $id = $roleuser->id;
            $status = $roleuser->user_status;
            $class='text-danger';
            $label='Deactive';
            if($status==1)
            {
                $class='text-success';
                $label='Active';
            }
          return  '<a class="'.$class.' actStatus" id = "user'.$id.'" data-sid="'.$id.'">'.$label.'</a>';
        })
        ->addColumn('action',function($roleuser){
            $id= $roleuser->id;

            if (auth()->user()->can('role-user-edit')) {
                $edit = '<a class="label label-success badge badge-light-success" href="' . url('admin/roleuser/'.$id.'/edit') . '"  title="View"><i class="fa fa-edit"></i>&nbsp</a>';
            } else {
                $edit = '';
            }

            if (auth()->user()->can('role-user-delete')) {
                $delete = '<a class="label label-danger badge badge-light-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$id.')"><i class="fa fa-trash"></i>&nbsp</a>';
            } else {
                $delete = '';
            }

            return $edit.' '.$delete;
        })
        ->rawColumns(['email','status','action']);//->toJson();
}
    /**
     * Get query source of dataTable.
     *
     * @param \App\RoleUser $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RoleUser $model)
    {
        return $model->newQuery()->select('user_id','role_id');
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
                   ->addAction(['width' => '80px']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return ['user_id','role_id'];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'RoleUser_' . date('YmdHis');
    }
}
