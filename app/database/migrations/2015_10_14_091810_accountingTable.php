<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('accounting', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',500);
            $table->string('type',20);
            $table->decimal('amount',18,2);
            $table->date('date');
            $table->text('description');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('accounting');
	}

}
