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
            ->editColumn('start_date', function ($booking) {
                return $booking->start_date ? $booking->start_date->timezone('Asia/Jerusalem')->format('Y-m-d H:i') : '';
            })
            ->editColumn('end_date', function ($booking) {
                return $booking->end_date ? $booking->end_date->timezone('Asia/Jerusalem')->format('Y-m-d H:i') : '';
            })
            ->editColumn('created_at', function ($booking) {
                return $booking->created_at ? $booking->created_at->timezone('Asia/Jerusalem')->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($booking) {
                return $booking->updated_at ? $booking->updated_at->timezone('Asia/Jerusalem')->diffForHumans() : '';
            })
            ->addColumn('action', function ($booking) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.bookings.edit', $booking->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $booking->id . '">Delete</a>
                <a class="btn btn-warning end-booking" data-id="' . $booking->id . '">END</a>
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
        return $model->newQuery()->with(['room', 'member', 'company']);
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
                Button::make('reload'),
                Button::make('create')->action("window.location = '" . route('admin.room-attribute.index') . "';")->text(__('Room Attributes'))
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
            Column::make('room.name')->title('Room'),
            Column::make('member.name')->title('Member'),
            Column::make('company.name')->title('Company'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('price'),
            Column::make('status_name', 'status')->title('Status'),
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
