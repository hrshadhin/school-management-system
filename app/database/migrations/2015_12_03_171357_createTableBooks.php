<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBooks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Books', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code',50)->unique();
			$table->string('title',250);
			$table->string('author',100);
			$table->integer('quantity')->unsigned();
			$table->string('rackNo',10);
			$table->string('rowNo',10);
			$table->string('type',10);
			$table->string('class',10);
			$table->string('desc',500);
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
		Schema::drop('Books');
	}

}
