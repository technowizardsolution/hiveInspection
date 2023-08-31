<?php

namespace App\DataTables\Admin;

use App\Category;
use Yajra\DataTables\Services\DataTable;
use App\Helper\GlobalHelper;
use Auth;

class CategoryDataTable extends DataTable
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
        ->addColumn('action', function ($category) {
            $id=$category->category_id;

            if (auth()->user()->can('categories-edit')) {
                $edit = '<a class="label label-success badge badge-light-success" href="' . url('admin/categories/'.$id.'/edit') . '"  title="Update"><i class="fa fa-edit"></i>&nbsp</a>';
            } else {
                $edit = '';
            }

            if (auth()->user()->can('categories-delete')) {
                $delete = '<a class="label label-danger badge badge-light-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$id.')"><i class="fa fa-trash"></i>&nbsp</a>';
            } else {
                $delete = '';
            }

            return $edit.' '.$delete.' ';
        })
        ->addColumn('status',  function($category) {
            $id=$category->category_id;
            $status = $category->status;
            $class='text-danger';
            $label='Deactive';
            if($status==1)
            {
                $class='text-success';
                $label='Active';
            }

            return  '<a class="'.$class.' actStatus" id = "cat'.$id.'" data-sid="'.$id.'">'.$label.'</a>';

        })
        ->editColumn('created_at', function($category) {
            return GlobalHelper::getFormattedDate($category->created_at);
        })
        ->rawColumns(['status','action']);//->toJson();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery()->select('category_id', 'name', 'status', 'created_at', 'updated_at');
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
        return [
            'category_id',
            'name',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Category_' . date('YmdHis');
    }
}
