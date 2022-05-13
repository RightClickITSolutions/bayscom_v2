<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientOrdersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'client_orders';

    /**
     * Run the migrations.
     * @table client_orders
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('client_type')->nullable();
            $table->integer('client_id')->unsigned();
            $table->string('transaction_id')->nullable();
            $table->string('refference_number', 225)->nullable();
            $table->text('order_snapshot')->nullable();
            $table->integer('sales_rep')->unsigned();
            $table->timestamp('created_at')->nullable()->default(null);

            $table->index(["client_id"], 'fk_Orders_customers1_idx');
            
            $table->index(["sales_rep"]);

            $table->foreign('client_id', 'fk_Orders_customers1_idx')
                ->references('id')->on('customers')
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
