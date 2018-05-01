<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {

			$table->increments('id');
			$table->string('firstname', 20);
			$table->string('lastname', 20);
			$table->string('desc', 200);
			$table->string('address', 500)->nullable();
			$table->string('login', 20)->unique();
			$table->string('email', 100)->unique();
			$table->string('group',20);
			$table->string('password', 64);
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
