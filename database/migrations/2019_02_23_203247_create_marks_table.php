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
            $table->unsignedInteger('academic_year_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('registration_id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('subject_id');
            $table->text('marks');
            $table->integer('total_marks');
            $table->string('grade');
            $table->decimal('point',5,2);
            $table->enum('present',[0,1])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('class_id')->references('id')->on('i_classes');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('registration_id')->references('id')->on('registrations');
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->unique(['class_id','exam_id','registration_id', 'subject_id']);

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
