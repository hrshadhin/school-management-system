<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFeeCollection extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stdBill', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('billNo',20);
			$table->string('class',20);
			$table->string('regiNo',20);
			$table->decimal('payableAmount',18,2);
			$table->decimal('paidAmount',18,2);
			$table->decimal('dueAmount',18,2);
			$table->date('payDate');
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
		Schema::drop('stdBill');
	}

}
