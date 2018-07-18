<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('event_time');
            $table->string('title');
            $table->string('slug',500);
            $table->string('cover_photo')->nullable();
            $table->string('cover_video')->nullable();
            $table->string('tags')->nullable();
            $table->longText('description');
            $table->string('slider_1')->nullable();
            $table->string('slider_2')->nullable();
            $table->string('slider_3')->nullable();
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
        Schema::dropIfExists('events');
    }
}
