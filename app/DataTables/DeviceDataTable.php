<?php

namespace App\DataTables;

use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

/**
 * @property int room_id
 */
class DeviceDataTable extends DataTable
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
            ->editColumn('created_at', function ($device) {
                return $device->created_at ? $device->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($device) {
                return $device->updated_at ? $device->updated_at->diffForHumans() : '';
            })
            ->addColumn('type', function ($device) {
                return $device->room ? $device->type->name : '';
            })
            ->addColumn('action', function ($device) {
                return '
                <div class="btn-group btn-group-sm">
                <a class="btn btn-success" href="' . route('admin.devices.edit', ['room_id' => $device->room_id, 'device' => $device]) . '">Edit</a>
                <a class="btn btn-danger delete-swal" data-url="' . route('admin.devices.destroy', ['room_id' => $device->room_id, 'device' => $device]) . '">Delete</a>
                </div>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Device $model
     * @return Builder
     */
    public function query(Device $model)
    {
        return $model->newQuery()->where('room_id', $this->room_id);
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
            Column::make('id')->title('ID'),
            Column::make('type'),
            Column::make('device_id')->title('Device ID'),
            Column::make('description'),
            Column::make('state'),
            Column::make('additional_information'),
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
        return 'Device_' . date('YmdHis');
    }
}
