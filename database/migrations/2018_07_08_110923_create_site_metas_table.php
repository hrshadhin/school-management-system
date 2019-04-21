<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('meta_key');
            $table->longText('meta_value');
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
        Schema::dropIfExists('site_metas');
    }
}
