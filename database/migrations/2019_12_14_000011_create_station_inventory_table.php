<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationInventoryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'station_inventory';

    /**
     * Run the migrations.
     * @table station_inventory
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('station_id')->unsigned();
            $table->string('product_name')->nullable();
            $table->string('quantity')->nullable();
            $table->timestamp('updated_at')->nullable()->default(null);

            $table->index(["station_id"], 'fk_station_inventory_stations1_idx');


            $table->foreign('station_id', 'fk_station_inventory_stations1_idx')
                ->references('id')->on('stations')
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
