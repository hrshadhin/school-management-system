<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('date_from');
            $table->date('date_upto');
            $table->enum('is_holiday',[0,1])->default(0);
            $table->enum('is_exam',[0,1])->default(0);
            $table->unsignedInteger('class_id')->nullable();
            $table->string('description', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('class_id')->references('id')->on('i_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_calendars');
    }
}
