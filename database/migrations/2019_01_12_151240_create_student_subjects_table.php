<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->unsignedInteger('registration_id');
            $table->unsignedInteger('subject_id');
            $table->tinyInteger('subject_type');

            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('registration_id')->references('id')->on('registrations');

        });

        Schema::create('st_subjects_log', function (Blueprint $table) {
            $table->unsignedInteger('registration_id');
            $table->text('log');
            $table->unsignedInteger('updated_by');
            $table->timestamp('updated_at');

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
        Schema::dropIfExists('st_subjects_log');
        Schema::dropIfExists('student_subjects');
    }
}
