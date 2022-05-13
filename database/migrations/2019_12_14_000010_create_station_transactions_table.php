<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationTransactionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'station_transactions';

    /**
     * Run the migrations.
     * @table station_transactions
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('product_id')->nullable();
            $table->integer('station_id')->unsigned();
            $table->string('refference_number', 225)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('order_id')->nullable()->comment('referer codee for comision entity.
data is pulled or linked based on comision code.');
            $table->timestamp('created_at')->nullable()->default(null);


            $table->foreign('station_id')
                ->references('id')->on('stations');
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
