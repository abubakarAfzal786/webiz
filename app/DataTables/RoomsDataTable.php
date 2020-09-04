<?php

namespace App\DataTables;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoomsDataTable extends DataTable
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
            ->editColumn('status', function ($room) {
                return $room->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Block</span>';
            })
            ->editColumn('created_at', function ($room) {
                return $room->created_at ? $room->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($room) {
                return $room->updated_at ? $room->updated_at->diffForHumans() : '';
            })
            ->addColumn('action', function ($room) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.rooms.edit', $room->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $room->id . '">Delete</a>
                </div>';
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Room $model
     * @return Builder
     */
    public function query(Room $model)
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
            ->setTableId('rooms-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
                Button::make('create')->action("window.location = '" . route('admin.room-facility.index') . "';")->text(__('Room Facilities'))
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
            Column::make('price'),
            Column::make('seats'),
            Column::make('location'),
            Column::make('status'),
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
        return 'Rooms_' . date('YmdHis');
    }
}
