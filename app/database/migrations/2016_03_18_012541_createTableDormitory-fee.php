<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDormitoryFee extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dormitory_fee', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('regiNo',20);
			$table->date('feeMonth');
			$table->decimal('feeAmount',10,2);
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
		Schema::drop('dormitory_fee');
	}

}
