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
            $table->string('class');
            $table->string('session');
            $table->string('section');
            $table->string('shift');
            $table->string('subject');

            $table->string('regiNo');
            $table->date('date');
            $table->string('status');
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
        Schema::drop('Attendance');
	}

}
