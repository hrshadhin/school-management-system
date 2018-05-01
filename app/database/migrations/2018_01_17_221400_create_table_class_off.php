<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClassOff extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('ClassOffDay', function(Blueprint $table)
        {
            $table->increments('id');
            $table->date('offDate');
            $table->enum('oType', ['E', 'O', 'CP']);
            $table->string('description',500)->nullable();
            $table->smallInteger('status')->default(1);
            $table->timestamps();

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('ClassOffDay');
	}

}
