<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_id');
            $table->string('name');
            $table->decimal('elective_subject_point_addition',5,2)->default(0.00);
            $table->text('marks_distribution_types');
            $table->enum('status', [0,1])->default(1);
            $table->boolean('open_for_marks_entry')->default(false);
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
        Schema::dropIfExists('exams');
    }
}
