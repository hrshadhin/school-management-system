<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClass extends Migration {

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('Class', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code',20)->unique;
			$table->string('name',100);
			$table->string('description',250);
			$table->boolean('combinePass')->default(0);
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
		Schema::drop('Class');
	}

}
