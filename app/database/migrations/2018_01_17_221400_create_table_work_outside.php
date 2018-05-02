<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkOutside extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('WorkOutside', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('regNo',255);
            $table->date('workDate');
            $table->string('paper',270)->nullable();
            $table->string('description',500)->nullable();
            $table->smallInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('regNo')
                ->references('regNo')->on('Teachers');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('WorkOutside');
	}

}
