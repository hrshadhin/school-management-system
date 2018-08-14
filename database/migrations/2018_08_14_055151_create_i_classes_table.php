<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            $table->string('name');
            $table->integer('numeric_value');
            $table->text('note')->nullable();
            $table->enum('status', [0,1])->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->foreign('teacher_id')->references('id')->on('employees');


        });

        Schema::create('i_class_teacher_log', function (Blueprint $table) {
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('teacher_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('class_id')->references('id')->on('i_classes');
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
        Schema::dropIfExists('i_class_teacher_log');
        Schema::dropIfExists('i_classes');
    }
}
