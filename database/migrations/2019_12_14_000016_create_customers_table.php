<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'customers';

    /**
     * Run the migrations.
     * @table customers
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('adderess')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('payment')->nullable();
            $table->integer('customer_type')->unsigned();
            $table->integer('price_scheme_id')->unsigned();
            $table->double('balance')->default(0);
            $table->integer('customer_creator')->unsigned();
            $table->index(["price_scheme_id"], 'fk_customers_price_schemes1_idx');

            $table->index(["customer_type"], 'fk_customers_cutomer_types1_idx');


            $table->foreign('price_scheme_id', 'fk_customers_price_schemes1_idx')
                ->references('id')->on('price_schemes')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('customer_type', 'fk_customers_cutomer_types1_idx')
                ->references('id')->on('cutomer_types')
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
