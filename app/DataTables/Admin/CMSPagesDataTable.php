<?php

namespace App\DataTables\Admin;

use App\CMSPage;
use Yajra\DataTables\Services\DataTable;
use App\Helper\GlobalHelper;
use DataTables;


class CMSPagesDataTable extends DataTable
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
        ->addColumn('action', function ($page) {
            $id=$page->cms_page_id;

            if (auth()->user()->can('page-edit')) {
                $edit = '<a class="label label-success badge badge-light-success" href="' . url('admin/pages/'.$id.'/edit') . '"  title="View"><i class="fa fa-edit"></i>&nbsp</a>';

            } else {
                $edit = '';
            }

            if (auth()->user()->can('page-delete')) {
                $delete = '<a class="label label-danger badge badge-light-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$id.')"><i class="fa fa-trash"></i>&nbsp</a>';
            } else {
                $delete = '';
            }

            return $edit.' '.$delete;
        })
        ->addColumn('status',  function($page) {
            $id=$page->cms_page_id;
            $status = $page->status;
            $class='text-danger';
            $label='Deactive';
            if($status==1)
            {
                $class='text-success';
                $label='Active';
            }
          return  '<a class="'.$class.' actStatus" id = "page'.$id.'" data-sid="'.$id.'">'.$label.'</a>';
        })
        ->editColumn('created_at', function($page) {
            return GlobalHelper::getFormattedDate($page->created_at);
        })
        ->rawColumns(['status','action']);//->toJson();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CMSPage $model)
    {
        return $model->newQuery()->select('cms_page_id', 'page_title', 'slug', 'status', 'created_at', 'updated_at');
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
            'cms_page_id',
            'page_title',
            'slug',
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
        return 'Cms_' . date('YmdHis');
    }
}
