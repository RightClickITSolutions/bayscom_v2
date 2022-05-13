<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseInventoryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'warehouse_inventory';

    /**
     * Run the migrations.
     * @table warehouse_inventory
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('wahrehouse_id')->unsigned();
            $table->string('product_name')->nullable();
            $table->string('quantity')->nullable();
            $table->timestamp('updated_at')->nullable()->default(null);

            $table->index(["wahrehouse_id"], 'fk_warehouse_inventory_warehouses1_idx');


            $table->foreign('wahrehouse_id', 'fk_warehouse_inventory_warehouses1_idx')
                ->references('id')->on('warehouses')
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
