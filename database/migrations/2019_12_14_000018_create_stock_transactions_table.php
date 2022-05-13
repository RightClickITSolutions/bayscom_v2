<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransactionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'stock_transactions';

    /**
     * Run the migrations.
     * @table stock_transactions
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('warehouse_id')->unsigned();
            $table->string('refference_number', 225)->nullable()->comment("uniqe reference ID asigned for commisions");
            $table->integer('quantity')->nullable();
            $table->string('transaction_type')->nullable()->comment('CREDIT/DEBIT');
            $table->integer('order_id')->unsigned();
            $table->timestamp('created_at')->nullable()->default(null);

            $table->index(["product_id"], 'fk_stock_transactions_Products1_idx');

            $table->index(["order_id"], 'fk_stock_transactions_Orders1_idx');

            $table->index(["warehouse_id"], 'fk_stock_transactions_warehouses1_idx');


            $table->foreign('product_id', 'fk_stock_transactions_Products1_idx')
                ->references('id')->on('Products')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('warehouse_id', 'fk_stock_transactions_warehouses1_idx')
                ->references('id')->on('warehouses')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('order_id', 'fk_stock_transactions_Orders1_idx')
                ->references('id')->on('client_orders')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
