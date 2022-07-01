<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'purchase_orders';

    /**
     * Run the migrations.
     * @table purchase_orders
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('warehouse_id')->nullable();
            $table->string('po_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('refference_number', 225)->nullable();
            $table->text('order_snapshot')->nullable();
            $table->string('sales_rep')->nullable()->comment('referer codee for comision entity.
data is pulled or linked based on comision code.');
            $table->timestamp('created_at')->nullable()->default(null);
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
