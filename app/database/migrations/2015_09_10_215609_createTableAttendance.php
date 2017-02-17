<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttendance extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('Attendance', function(Blueprint $table)
        {

					$table->increments('id');
					$table->string('regiNo',20);
					$table->date('date');
					$table->dateTime('created_at');
					$table->foreign('regiNo')
					->references('regiNo')->on('Student');



        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('Attendance');
	}

}
