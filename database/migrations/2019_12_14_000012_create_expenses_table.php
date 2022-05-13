<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'expenses';

    /**
     * Run the migrations.
     * @table expenses
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->integer('expense_type_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->index(["expense_type_id"], 'fk_expenses_expense_type1_idx');


            $table->foreign('expense_type_id', 'fk_expenses_expense_type1_idx')
                ->references('id')->on('expense_type')
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
