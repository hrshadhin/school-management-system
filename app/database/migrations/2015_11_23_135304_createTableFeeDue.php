<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFeeDue extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('billHistory', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('billNo',20);
			$table->string('title',100);
			$table->string('month',5);
			$table->decimal('fee',18,2);
			$table->decimal('lateFee',18,2);
			$table->decimal('total',18,2);
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('billHistory');
	}

}
