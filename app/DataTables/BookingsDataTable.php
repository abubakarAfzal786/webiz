<?php

namespace App\DataTables;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BookingsDataTable extends DataTable
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
            ->addColumn('room', function ($booking) {
                return $booking->room ? $booking->room->name : '';
            })
            ->addColumn('member', function ($booking) {
                return $booking->member ? $booking->member->name : '';
            })
            ->editColumn('start_date', function ($booking) {
                return $booking->start_date ? $booking->created_at->format('Y-m-d h:i A') : '';
            })
            ->editColumn('end_date', function ($booking) {
                return $booking->end_date ? $booking->created_at->format('Y-m-d h:i A') : '';
            })
            ->editColumn('status', function ($booking) {
                return $booking->status_name;
            })
            ->editColumn('created_at', function ($booking) {
                return $booking->created_at ? $booking->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($booking) {
                return $booking->updated_at ? $booking->updated_at->diffForHumans() : '';
            })
            ->addColumn('action', function ($booking) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.bookings.edit', $booking->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $booking->id . '">Delete</a>
                </div>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Booking $model
     * @return Builder
     */
    public function query(Booking $model)
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
            ->setTableId('bookings-table')
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
            Column::make('room'),
            Column::make('member'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('price'),
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
        return 'Bookings_' . date('YmdHis');
    }
}
