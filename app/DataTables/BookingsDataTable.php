<?php

namespace App\DataTables;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Mockery\Undefined;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
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
        if (request()->get('start_date') !== null && request()->get('start_date')) {
            $query->whereRaw('DATE(start_date)=?', [request()->get('start_date')])->whereRaw('DATE(end_date)=?', [request()->get('end_date')]);
        }
        return datatables()
            ->eloquent($query)
            ->editColumn('start_date', function ($booking) {
                return $booking->start_date ? $booking->start_date->timezone('Asia/Jerusalem')->format('Y-m-d H:i') : '';
            })
            ->editColumn('end_date', function ($booking) {
                return $booking->end_date ? $booking->end_date->timezone('Asia/Jerusalem')->format('Y-m-d H:i') : '';
            })
            ->editColumn('extend_minutes', function ($booking) {
                return $booking->extend_minutes ? $booking->end_date->diffInMinutes($booking->extend_minutes)." Minutes" : '';
            })
            ->editColumn('created_at', function ($booking) {
                return $booking->created_at ? $booking->created_at->timezone('Asia/Jerusalem')->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($booking) {
                return $booking->updated_at ? $booking->updated_at->timezone('Asia/Jerusalem')->diffForHumans() : '';
            })
            ->addColumn('extras', function ($booking) {
                $extras = '';
                foreach ($booking->room_attributes as $room_attribute) {
                    if ($room_attribute->pivot->quantity) $extras .= '<span class="badge badge-primary">' . $room_attribute->name . ' (' . $room_attribute->pivot->quantity . ')</span>';
                }
                return $extras;
            })
            ->addColumn('action', function ($booking) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.bookings.edit', $booking->id) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-id="' . $booking->id . '">Delete</a>
                <a class="btn btn-warning end-booking" data-id="' . $booking->id . '">END</a>
                </div>';
            })
            ->rawColumns(['extras', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Booking $model
     * @return Builder
     */
    public function query(Booking $model)
    {
        $member_id = request()->get('member_id');
        $q = $model->newQuery()->with(['room', 'member', 'company', 'room_attributes']);
        if ($member_id) $q = $q->where('member_id', $member_id);
        return $q;
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
            Column::make('extend_minutes')->title('Pango Time'),
            Column::make('price'),
            Column::make('status_name', 'status')->title('Status'),
            Column::make('extras')->orderable(false),
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
