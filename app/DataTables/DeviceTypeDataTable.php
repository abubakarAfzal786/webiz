<?php

namespace App\DataTables;

use App\Models\DeviceType;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeviceTypeDataTable extends DataTable
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
            ->editColumn('icon', function ($type) {
                return $type->icon ? '<i class="' . $type->icon . ' fa-2x"></i>' : '';
            })
            ->editColumn('created_at', function ($type) {
                return $type->created_at ? $type->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($type) {
                return $type->updated_at ? $type->updated_at->diffForHumans() : '';
            })
            ->addColumn('action', function ($type) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.device-type.edit', $type->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-url="' . route('admin.device-type.destroy', [$type->id]) . '">Delete</a>
                </div>';
            })
            ->rawColumns(['icon', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param DeviceType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DeviceType $model)
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
            ->setTableId('myDataTable')
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
            Column::make('icon')->width(30),
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
        return 'DeviceType_' . date('YmdHis');
    }
}
