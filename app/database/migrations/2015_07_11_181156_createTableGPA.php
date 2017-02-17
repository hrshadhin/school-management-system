<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGPA extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('GPA', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('for',2);
			$table->string('gpa',20);
			$table->float('grade');
			$table->integer('markfrom');
			$table->integer('markto');
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
		Schema::drop('GPA');
	}

}
