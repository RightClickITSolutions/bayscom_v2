<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'authorizations';

    /**
     * Run the migrations.
     * @table authorizations
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('process_type', 45);
            $table->integer('process_id');
            $table->string('l0', 45)->default('0');
            $table->string('l1', 45)->default('0');
            $table->string('l2', 45)->default('0');
            $table->string('l3', 45)->default('0');
            $table->string('l4', 45)->default('0');
            $table->string('l5', 45)->default('0');

            $table->index(["process_id"]);
            $table->index(["process_type"]);
            
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
