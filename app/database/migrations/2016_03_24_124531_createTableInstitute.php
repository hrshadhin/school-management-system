<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInstitute extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institute', function(Blueprint $table)
		{
		  $table->string('name',250);
			$table->string('establish',10);
		  $table->string('email',100);
		  $table->string('web',80);
		  $table->string('phoneNo',15);
		  $table->string('address',250);
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
		Schema::drop('institute');
	}

}
