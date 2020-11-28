<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransactionDataTable extends DataTable
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
            ->addColumn('member', function ($transaction) {
                return $transaction->member ? $transaction->member->name : '';
            })
            ->addColumn('room', function ($transaction) {
                return $transaction->room ? $transaction->room->name : '';
            })
            ->editColumn('type', function ($transaction) {
                return Transaction::listTypes()[$transaction->type];
            })
            ->editColumn('created_at', function ($transaction) {
                return $transaction->created_at ? $transaction->created_at->diffForHumans() : '';
            })
            ->editColumn('updated_at', function ($transaction) {
                return $transaction->updated_at ? $transaction->updated_at->diffForHumans() : '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Transaction $model
     * @return Builder
     */
    public function query(Transaction $model)
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
            Column::make('id')->title('ID'),
            Column::make('member'),
            Column::make('room'),
            Column::make('type'),
            Column::make('credit'),
            Column::make('price'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Transaction_' . date('YmdHis');
    }
}