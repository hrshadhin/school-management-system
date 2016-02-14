<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMeritList extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('MeritList', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('class');
			$table->string('session');
			$table->string('exam');
            $table->string('regiNo');
            $table->decimal('totalNo',5,2);
            $table->decimal('point',18,2);
            $table->string('grade');
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
		Schema::drop('MeritList');
	}

}
