<?php

namespace App\DataTables;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MembersDataTable extends DataTable
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
            ->editColumn('status', function ($member) {
                return $member->status ?
                    '<div class="status"><p style="background: #0A8FEF;">' . __('Active') . '</p></div>' :
                    '<div class="status"><p style="background: #FF5260;">' . __('Block') . '</p></div>';
            })
            ->addColumn('avatar', function ($member) {
                return '<div class="member-img"><img src="' . ($member->avatar_url ? $member->avatar_url : asset('images/default-user.png')) . '" alt=""></div>';
            })
            ->editColumn('created_at', function ($member) {
                return $member->created_at->format('Y-m-d H:i') ?? null;
            })
            ->addColumn('action', function ($member) {
                return '<div class="action"><a href="' . route('admin.members.profile', $member->id) . '" class="main-btn yellow">' . __('Edit & More') . '</a></div>';
            })
            ->rawColumns(['status', 'avatar', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Member $model
     * @return Builder
     */
    public function query(Member $model)
    {
        $company_id = request()->get('company_id');
        $newQuery = $model->newQuery()->withoutGlobalScopes();
        if ($company_id) $newQuery = $newQuery->where('company_id', $company_id);
        $newQuery = $newQuery->with('avatar')->orderBy('id', 'desc');

        return $newQuery;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('members-table')
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
//            Column::make('id'),
            Column::make('name'),
            Column::make('phone'),
            Column::make('email'),
            Column::make('status'),
            Column::make('created_at'),
//            Column::make('balance'),
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
        return 'Members_' . date('YmdHis');
    }
}
