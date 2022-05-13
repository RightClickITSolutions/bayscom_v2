<?php

namespace App\DataTables;

use App\Models\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
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
            ->editColumn('name', function ($model) {
                return '<td>
                            <a href="'.url('/customer/transactions/'.$model->id).'">'.$model->name.'</a>
                        </td>';
            })
            ->editColumn('deposits', function ($model) {
                return number_format($model->totalPurchases());
            })
            ->editColumn('balance', function ($model) {
                return number_format($model->balance);
            })
            ->rawColumns(['name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
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
                    ->parameters([
                        'paging' => true,
                        'searching' => true,
                        'info' => false,
                        'searchDelay' => 350,
                        'createdRow' => "function(row, data, index) {                             
                            var amount= parseFloat( data['balance'].replace(/,/g, '') ); // replace , thousands separator
                            if ( amount < 0 ) {
                                $('td', row).eq(2).addClass('negative');
                            } else {
                                $('td', row).eq(2).addClass('positive');
                            }
                        }",
                    ])
                    ->setTableId('customers-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('export'),
                        Button::make('pdf'),
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
            //       ->exportable(false)
            //       ->printable(false)
            //       ->addClass('text-center'),
            Column::make('name'),
            Column::make('address'),
            Column::make('balance')->title('Balance(₦)'),
            Column::computed('deposits')->title('Deposits(₦)'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Customers_' . date('YmdHis');
    }
}
