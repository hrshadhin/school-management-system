<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('academic_year_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('registration_id');
            $table->date('attendance_date');
            $table->dateTime('in_time');
            $table->dateTime('out_time');
            $table->time('staying_hour');
            $table->string('status',20)->nullable();//1 = in late, 2 = out early
            $table->enum('present', [0,1])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('class_id')->references('id')->on('i_classes');
            $table->foreign('registration_id')->references('id')->on('registrations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_attendances');
    }
}
