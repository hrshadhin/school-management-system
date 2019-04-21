<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->date('attendance_date');
            $table->dateTime('in_time');
            $table->dateTime('out_time');
            $table->time('working_hour');
            $table->string('status',20)->nullable();//1 = in late, 2 = out early
            $table->enum('present', [0,1])->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_attendances');
    }
}
