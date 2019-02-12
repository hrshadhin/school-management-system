<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->date('holi_date');
            $table->unsignedInteger('academic_year_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();


            $table->foreign('academic_year_id')->references('id')->on('academic_years');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}
