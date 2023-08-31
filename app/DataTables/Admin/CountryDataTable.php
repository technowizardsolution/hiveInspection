<?php

namespace App\DataTables\Admin;

use App\Country;
use Yajra\DataTables\Services\DataTable;
use App\Helper\GlobalHelper;

class CountryDataTable extends DataTable
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
        ->addColumn('action', function ($country) {
        $id = $country->country_id;

        if (auth()->user()->can('country-view')) {
            $view = '<a class="label label-primary badge badge-light-primary" href="' . url('admin/countries/'.$id) . '"  title="View"><i class="fa fa-eye"></i>&nbsp</a>';
        } else {
            $view = '';
        }

        if (auth()->user()->can('country-edit')) {
            $edit = '<a class="label label-success badge badge-light-success" href="' . url('admin/countries/'.$id.'/edit') . '"  title="Update"><i class="fa fa-edit"></i>&nbsp</a>';

        } else {
            $edit = '';
        }

        if (auth()->user()->can('country-delete')) {
            $delete = '<a class="label label-danger badge badge-light-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$id.')"><i class="fa fa-trash"></i>&nbsp</a>';
        } else {
            $delete = '';
        }

        return $view.' '.$edit.' '.$delete;
        })
        ->addColumn('status',  function($country) {
            $id = $country->country_id;
            $status = $country->status;
            $class='text-danger';
            $label='Deactive';
            if($status==1)
            {
                $class='text-success';
                $label='Active';
            }
          return  '<a class="'.$class.' actStatus" id = "country'.$id.'" data-sid="'.$id.'">'.$label.'</a>';
        })
        ->editColumn('created_at', function($country) {
            return GlobalHelper::getFormattedDate($country->created_at);
        })
        ->rawColumns(['status','action']);//->toJson();
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Country $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Country $model)
    {
        return $model->newQuery()->select('country_id', 'sortname', 'name', 'phonecode', 'status', 'created_at', 'updated_at');
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
        return ['country_id', 'sortname', 'name', 'phonecode', 'status', 'created_at', 'updated_at'];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Country_' . date('YmdHis');
    }
}
