<?php

namespace App\DataTables;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CompanyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('logo', function ($company) {
                return '<div class="text-center"><img class="img img-fluid" src="' . ($company->logo_url ?? asset('images/default-user.png')) . '" alt=""></div>';
            })
            ->editColumn('created_at', function ($company) {
                return $company->created_at ? $company->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($company) {
                return $company->updated_at ? $company->updated_at->diffForHumans() : '';
            })
            ->addColumn('action', function ($company) {
               if($company->status==true){
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-light" href="' . route('admin.members.index', ['company_id' => $company->id]) . '">Members</a>
                <a class="btn btn-success" href="' . route('admin.companies.edit', $company->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $company->id . '">Delete</a>
                <a class="btn btn-danger block-company" data-id="' . $company->id . '">Block</a>
               </div>';
               }else{
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-light" href="' . route('admin.members.index', ['company_id' => $company->id]) . '">Members</a>
                <a class="btn btn-success" href="' . route('admin.companies.edit', $company->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $company->id . '">Delete</a>
                <a class="btn btn-success unblock-company" data-id="' . $company->id . '">Unblock</a>
               </div>';
               }
            })
            ->rawColumns(['logo', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Company $model
     * @return Builder
     */
    public function query(Company $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('company-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('logo'),
            Column::make('name'),
            Column::make('balance'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Company_' . date('YmdHis');
    }
}
