<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug',500);
            $table->string('image_sm');
            $table->string('image_lg');
            $table->string('teacher');
            $table->string('room_no',50);
            $table->integer('capacity');
            $table->string('shift');
            $table->longText('short_description');
            $table->longText('description')->nullable();
            $table->longText('outline')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_profiles');
    }
}
