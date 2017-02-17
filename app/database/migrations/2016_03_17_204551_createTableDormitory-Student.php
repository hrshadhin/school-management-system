<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDormitoryStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dormitory_student', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('regiNo',20);
			$table->date('joinDate');
			$table->date('leaveDate');
			$table->integer('dormitory');
			$table->string('roomNo',4);
			$table->decimal('monthlyFee',10,2);
			$table->string('isActive',3);
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
		Schema::drop('dormitory_student');
	}

}
