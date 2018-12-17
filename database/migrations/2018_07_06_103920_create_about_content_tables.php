<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'about_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('why_content',500);
            $table->string('key_point_1_title',100);
            $table->longText('key_point_1_content');
            $table->string('key_point_2_title',100)->nullable();
            $table->longText('key_point_2_content')->nullable();
            $table->string('key_point_3_title',100)->nullable();
            $table->longText('key_point_3_content')->nullable();
            $table->string('key_point_4_title',100)->nullable();
            $table->longText('key_point_4_content')->nullable();
            $table->string('key_point_5_title',100)->nullable();
            $table->longText('key_point_5_content')->nullable();
            $table->string('about_us',500);
            $table->string('who_we_are',1000);
            $table->text('intro_video_embed_code');
            $table->string('video_site_link',500)->nullable();
            $table->timestamps();
            $table->userstamps();
        }
        );
        Schema::create(
            'about_sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('order')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('about_contents');
        Schema::dropIfExists('about_sliders');
    }
}
