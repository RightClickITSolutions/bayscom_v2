<?php

namespace App\DataTables;

use App\Models\CustomerTransaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class CustomerTransactionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('id', function ($model) {
                return '<td>
                            <a href="' . url('/prf/payment-history/' . $model->order_id) . '">' . $model->id . '</a>
                        </td>';
            })
            ->editColumn('amount', function ($model) {
                return number_format($model->amount);
            })
            ->rawColumns(['id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CustomerTransaction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CustomerTransaction $model)
    {
        $now = Carbon::now();
        $to = Carbon::create($now->year, $now->month, $now->day);
        $from = Carbon::create($now->year, $now->month, $now->day)->subMonth(5);
        return $model->newQuery()->whereBetween('created_at', [$from, $to]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('customertransaction-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->parameters([
                'buttons'      =>
                [
                    [
                        'text' => 'My custom button',
                    ],
                    'csv',
                    'excel',
                    'pdf'
                ],
            ]);
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
            Column::make('transaction_type'),
            Column::make('amount')->title('Amount (N)'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CustomerTransaction_' . date('YmdHis');
    }
}
