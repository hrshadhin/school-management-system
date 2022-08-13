<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('regi_no',20);
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('academic_year_id');
            $table->integer('roll_no')->nullable();
            $table->string('shift',15)->nullable();
            $table->string('card_no',50)->nullable();
            $table->string('board_regi_no',50)->nullable();
            $table->string('house',100)->nullable();
            $table->enum('status', [0,1])->default(1);
            $table->enum('is_promoted', [0,1])->default(0);
            $table->unsignedInteger('old_registration_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('class_id')->references('id')->on('i_classes');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('old_registration_id')->references('id')->on('registrations');
            $table->index('regi_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
