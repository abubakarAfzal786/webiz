<?php

namespace App\DataTables;

use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PackageDataTable extends DataTable
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
            ->editColumn('privileges', function ($package) {
                return (mb_strlen(strip_tags($package->privileges)) > 50) ? mb_substr(strip_tags($package->privileges), 0, 50) . '...' : $package->privileges;
            })
            ->editColumn('created_at', function ($package) {
                return $package->created_at ? $package->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($package) {
                return $package->updated_at ? $package->updated_at->diffForHumans() : '';
            })
            ->addColumn('action', function ($package) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.packages.edit', $package->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $package->id . '">Delete</a>
                </div>';
            })
            ->rawColumns(['privileges', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Package $model
     * @return Builder
     */
    public function query(Package $model)
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
            ->setTableId('packages-table')
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
            Column::make('name'),
            Column::make('privileges'),
            Column::make('price'),
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
        return 'Packages_' . date('YmdHis');
    }
}
