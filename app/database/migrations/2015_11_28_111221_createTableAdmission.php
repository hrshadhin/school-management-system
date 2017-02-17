<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdmission extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admission', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('refNo',20);
			$table->string('seatNo',20);
			$table->string('transactionNo',50);
			$table->string('stdName',100);
			$table->string('nationality',50);
			$table->string('class',10);
			$table->string('session',10);
			$table->string('dob');
			$table->string('photo',20);
			$table->string('campus',50);
			$table->string('keeping',50);
			$table->string('fatherName',100);
			$table->string('fatherCellNo',20);
			$table->string('motherName',100);
			$table->string('motherCellNo',50);
			$table->string('status',50);
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
		Schema::drop('admission');
	}

}
