<?php

namespace App\DataTables;

use App\Models\RoomAttribute;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoomAttributeDataTable extends DataTable
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
            ->editColumn('unit', function ($roomAttribute) {
                return RoomAttribute::listUnits()[$roomAttribute->unit] ?? '';
            })
            ->editColumn('created_at', function ($roomAttribute) {
                return $roomAttribute->created_at ? $roomAttribute->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($roomAttribute) {
                return $roomAttribute->updated_at ? $roomAttribute->updated_at->diffForHumans() : '';
            })
            ->addColumn('action', function ($roomAttribute) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.room-attribute.edit', $roomAttribute->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $roomAttribute->id . '">Delete</a>
                </div>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param RoomAttribute $model
     * @return Builder
     */
    public function query(RoomAttribute $model)
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
            ->setTableId('room-attribute-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('unit'),
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
        return 'RoomAttribute_' . date('YmdHis');
    }
}
