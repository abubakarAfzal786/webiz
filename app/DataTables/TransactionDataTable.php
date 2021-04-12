<?php

namespace App\DataTables;

use App\Models\Transaction;
use Carbon\Carbon;
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
                return $transaction->member ? '<a href="' . route('admin.members.profile', $transaction->member_id) . '">' . $transaction->member->name . '</a>' : '';
            })
            ->addColumn('company', function ($transaction) {
                return $transaction->company ? $transaction->company->name : ($transaction->member && $transaction->member->company ? $transaction->member->company->name : null);
            })
            ->addColumn('room', function ($transaction) {
                return $transaction->room ? $transaction->room->name : '';
            })
            ->editColumn('type', function ($transaction) {
                return Transaction::listTypes()[$transaction->type];
            })
            ->editColumn('created_at', function ($transaction) {
                return $transaction->created_at ? $transaction->created_at->format('Y-m-d H:i') : '';
            })
            ->rawColumns(['member']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Transaction $model
     * @return Builder
     */
    public function query(Transaction $model)
    {
        $query = $model->newQuery()->with(['room', 'member.company', 'company']);

        $month = $this->month;
        if ($month) {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
            $query = $query->whereBetween('created_at', [$start, $end]);
        }

        return $query;
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
            Column::make('member', 'member_id'),
            Column::make('company', 'company_id'),
            Column::make('room', 'room_id'),
            Column::make('type'),
            Column::make('credit'),
            Column::make('created_at')->title('Date'),
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
