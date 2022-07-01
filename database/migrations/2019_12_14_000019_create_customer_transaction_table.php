<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTransactionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'customer_transaction';

    /**
     * Run the migrations.
     * @table customer_transaction
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('comment', 220)->nullable();
            $table->integer('warehouse_id')->unsigned();
            $table->string('transaction_type')->comment('CREDIT/DEBIT');
            $table->double('amount')->nullable();
            $table->double('balance')->nullable();
            $table->timestamp('create_time')->nullable();
            $table->timestamp('update_time')->nullable();
            $table->string('reference_number', 225)->nullable();
            $table->integer('order_id')->unsigned();

            $table->index(["order_id"], 'fk_customer_transaction_Orders1_idx');

            $table->index(["customer_id"], 'fk_customer_transaction_customers1_idx');


            $table->foreign('customer_id', 'fk_customer_transaction_customers1_idx')
                ->references('id')->on('customers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('order_id', 'fk_customer_transaction_Orders1_idx')
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
