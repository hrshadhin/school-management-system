<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubject extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Subject', function(Blueprint $table)
		{
			$table->increments('id');
		  $table->string('code',20);
			$table->string('name',250);
			$table->string('type',30);
			$table->string('stdgroup',30);
			$table->string('subgroup',30);
			$table->string('class',100);
			$table->string('gradeSystem',2);
			$table->integer('totalfull')->default(0);
			$table->integer('totalpass')->default(0);
			$table->integer('wfull')->default(0);
			$table->integer('wpass')->default(0);
			$table->integer('mfull')->default(0);
			$table->integer('mpass')->default(0);
			$table->integer('sfull')->default(0);
			$table->integer('spass')->default(0);
			$table->integer('pfull')->default(0);
			$table->integer('ppass')->default(0);

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
		Schema::drop('Subject');
	}

}
