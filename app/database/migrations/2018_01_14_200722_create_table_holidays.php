<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHolidays extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('Holidays', function(Blueprint $table)
        {
            $table->increments('id');
            $table->date('holiDate');
            $table->string('description',500)->nullable();
            $table->timestamp('createdAt');
            $table->boolean('status');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('Holidays');
	}

}
