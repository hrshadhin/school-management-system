<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('subject_id');

            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('teacher_id')->references('id')->on('employees');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_subjects');
    }
}
