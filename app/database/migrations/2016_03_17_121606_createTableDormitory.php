<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDormitory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dormitory', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',50);
			$table->integer('numOfRoom')->defualt(0);
			$table->string('address',150);
			$table->string('description',200);
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
		Schema::drop('dormitory');
	}

}
