<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableissuebook extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issueBook', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('regiNo',20);
			$table->string('code',50);
		  $table->integer('quantity')->unsigned();
			$table->date('issueDate');
			$table->date('returnDate');
			$table->decimal('fine',18,2)->default(0.00);
			$table->string('Status',10)->default('Borrowed');
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
		Schema::drop('issueBook');
	}

}
