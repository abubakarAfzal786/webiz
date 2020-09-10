<?php

namespace App\DataTables;

use App\Models\RoomFacility;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoomFacilityDataTable extends DataTable
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
            ->editColumn('icon', function ($facility) {
                return $facility->icon ? '<i class="' . $facility->icon . ' fa-2x"></i>' : '';
            })
            ->editColumn('created_at', function ($member) {
                return $member->created_at ? $member->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($member) {
                return $member->updated_at ? $member->updated_at->diffForHumans() : '';
            })
            ->addColumn('action', function ($facility) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.room-facility.edit', $facility->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $facility->id . '">Delete</a>
                </div>';
            })
            ->rawColumns(['icon', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param RoomFacility $model
     * @return Builder
     */
    public function query(RoomFacility $model)
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
            ->setTableId('room-facility-table')
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
        return 'RoomFacility_' . date('YmdHis');
    }
}
