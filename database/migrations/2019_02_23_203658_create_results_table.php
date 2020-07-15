<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('academic_year_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('registration_id');
            $table->unsignedInteger('exam_id');
            $table->integer('total_marks');
            $table->string('grade');
            $table->decimal('point',5,2);
            $table->unsignedSmallInteger('subject_fail_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();


            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('class_id')->references('id')->on('i_classes');
            $table->foreign('registration_id')->references('id')->on('registrations');
            $table->foreign('exam_id')->references('id')->on('exams');
        });

        Schema::create('result_publish', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('academic_year_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('exam_id');
            $table->date('publish_date');

            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('class_id')->references('id')->on('i_classes');
            $table->foreign('exam_id')->references('id')->on('exams');
        });

        Schema::create('result_combines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('registration_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('exam_id');
            $table->integer('total_marks');
            $table->string('grade');
            $table->decimal('point',5,2);

            $table->foreign('registration_id')->references('id')->on('registrations');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('exam_id')->references('id')->on('exams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_combines');
        Schema::dropIfExists('result_publish');
        Schema::dropIfExists('results');
    }
}
