<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceSchemesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'price_schemes';

    /**
     * Run the migrations.
     * @table price_schemes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('product_name')->nullable();
            $table->double('price')->nullable();
            $table->integer('price_scheme_id')->unsigned();
            $table->string('customer_type')->nullable();

            $table->index(["price_scheme_id"], 'fk_price_schemes_cutomer_types1_idx');


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
