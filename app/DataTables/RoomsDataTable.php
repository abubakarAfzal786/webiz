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
                return $room->status ?
                    '<div class="status"><p style="background: #0A8FEF;">' . __('Active') . '</p></div>' :
                    '<div class="status"><p style="background: #FF5260;">' . __('Block') . '</p></div>';
            })
            ->addColumn('images', function ($room) {
                $imagesHTML = '';
                $images = $room->images;
                $count = count($images);
                if ($count) {
                    for ($i = 0; $i < ($count < 2 ? $count : 2); $i++) {
                        $imagesHTML .= '<div class="item"><span class="photo"><img src="' . $images[$i]->url . '" alt=""></span></div>';
                    }
                    if ($count > 2) $imagesHTML .= '<div class="item"><p>' . ($count - 2) . '+</p></div>';
                }

                return '<div class="photo-preview">' . $imagesHTML . '</div>';
            })
            ->addColumn('action', function ($room) {
                return '<div class="action"><a href="' . route('admin.rooms.edit', $room->id) . '" class="main-btn yellow">' . __('Edit') . '</a></div>';
//                <a class="btn btn-danger delete-swal" data-id="' . $room->id . '">Delete</a>
            })
            ->rawColumns(['status', 'images', 'action']);
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
                Button::make('create')->action("window.location = '" . route('admin.room-facility.index') . "';")->text(__('Room Facilities')),
                Button::make('create')->action("window.location = '" . route('admin.room-type.index') . "';")->text(__('Room Types'))
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
//            Column::make('id'),
            Column::make('name'),
            Column::make('price'),
            Column::make('images'),
            Column::make('seats'),
            Column::make('status'),
//            Column::make('created_at'),
//            Column::make('updated_at'),
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
