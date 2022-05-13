<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLubebayTransactionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'lubebay_transactions';

    /**
     * Run the migrations.
     * @table lubebay_transactions
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('customer_name', 220)->nullable();
            $table->string('comment', 220)->nullable();
            $table->double('total_amount')->nullable();
            $table->string('refference_number', 225)->nullable();
            $table->text('order_snapshot')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('update_time')->nullable();
            
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
