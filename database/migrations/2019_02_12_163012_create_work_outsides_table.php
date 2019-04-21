<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOutsidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_outsides', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->date('work_date');
            $table->string('document')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_outsides');
    }
}
