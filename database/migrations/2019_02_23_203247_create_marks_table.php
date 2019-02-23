<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('registration_id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('subject_id');
            $table->text('marks');
            $table->integer('total_marks');
            $table->string('grade');
            $table->decimal('point',5,2);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->foreign('registration_id')->references('id')->on('registrations');
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('subject_id')->references('id')->on('subjects');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
