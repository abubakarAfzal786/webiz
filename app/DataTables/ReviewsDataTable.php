<?php

namespace App\DataTables;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReviewsDataTable extends DataTable
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
            ->addColumn('avatar', function ($review) {
                return $review->member->avatar_url ? '<div class="member-img"><img src="' . $review->member->avatar_url . '" alt=""></div>' : '';
            })
            ->addColumn('member_name', function ($review) {
                return $review->member ? $review->member->name : '';
            })
            ->addColumn('room_name', function ($review) {
                return $review->room ? $review->room->name : '';
            })
            ->editColumn('rate', function ($review) {
                $stars = '';
                for ($i = 1; $i <= round($review->rate); $i++) {
                    $stars .= '<span class="icon-star"></span>';
                }

                for ($i = 1; $i <= round(5 - round($review->rate)); $i++) {
                    $stars .= '<span class="icon-empty"></span>';
                }

                return '<div class="rating"><p>' . $stars . '</p></div>';
            })
            ->addColumn('date', function ($review) {
                return $review->created_at ? '<span data-order="' . $review->created_at . '">' . $review->created_at->diffForHumans() . '</span>' : '';
            })
            ->rawColumns(['avatar', 'rate', 'date']);
//            ->editColumn('updated_at', function ($review) {
//                return $review->updated_at ? $review->updated_at->diffForHumans() : '';
//            })
//            ->addColumn('action', function ($review) {
//                return '
//                <div class="btn-group btn-group-sm">
//                <a class="btn btn-success" href="' . route('admin.reviews.edit', $review->id) . '">Edit</a>
//                <a class="btn btn-danger delete-swal" data-id="' . $review->id . '">Delete</a>
//                </div>';
//            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Review $model
     * @return Builder
     */
    public function query(Review $model)
    {
        return $model->newQuery()->with('member.avatar', 'room');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('reviews-table')
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
            Column::make('description'),
            Column::make('rate'),
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
        return 'Reviews_' . date('YmdHis');
    }
}
