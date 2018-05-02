<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTeacherAttendance extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('TeacherAttendance', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('regNo',255);
            $table->date('date');
//            $table->string('vEMPNO',20);
            $table->time('dIN_TIME');
            $table->time('dOUT_TIME');
            $table->decimal('nWorkingHOUR',8,2);
            $table->decimal('nLATE',8,2)->nullable();
            $table->string('vSTATUS',10);
            $table->string('REMARKS',200)->nullable();
            $table->string('vDEPT_NAME',40)->nullable();
            $table->string('vSECTION_NAME',50)->nullable();
            $table->string('vDES_NAME',40)->nullable();
            $table->string('vSHIFT_CODE',10)->nullable();
            $table->string('vWEEKLY_OFF',15)->nullable();
            $table->timestamp('created_at');
            $table->foreign('regNo')
                ->references('regNo')->on('Teachers');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('TeacherAttendance');
	}

}
