<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'sliders', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('subtitle');
                $table->string('image');
                $table->integer('order')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->userstamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
