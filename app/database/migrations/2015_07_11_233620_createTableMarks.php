<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMarks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Marks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('class',20);
			$table->string('section',1);
			$table->string('shift',20);
			$table->string('session',10);
			$table->string('regiNo',20);
			$table->string('exam',50);
			$table->string('subject',100);
			$table->integer('written');
			$table->integer('mcq');
			$table->integer('practical');
			$table->integer('ca');
			$table->integer('total');
		  $table->string('grade');
			$table->decimal('point',3,2);
			$table->string('Absent',10)->default('No');
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
		Schema::drop('Marks');
	}

}
